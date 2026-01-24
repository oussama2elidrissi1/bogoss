/**
 * Système de panier de réservation avec gestion des options
 * Architecture: Service -> Options par service -> Panier -> Booking
 */

class BookingCart {
    constructor() {
        this.cart = [];
        this.services = new Map();
        this.serviceOptions = new Map();
        this.totals = {
            subtotal: 0,
            discount_total: 0,
            total: 0,
            total_duration: 0,
        };
        this.apiBaseUrl = '/api';
        this.authToken = document.querySelector('meta[name="csrf-token"]')?.content;
    }

    /**
     * Initialiser le panier et charger les services
     */
    async init() {
        try {
            await this.loadServices();
            this.renderCart();
            this.attachEventListeners();
        } catch (error) {
            console.error('Erreur initialisation panier:', error);
            this.showError('Impossible de charger les services');
        }
    }

    /**
     * Charger les services avec leurs options depuis l'API
     */
    async loadServices(category = null, search = null) {
        const params = new URLSearchParams();
        if (category) params.append('category', category);
        if (search) params.append('search', search);

        const response = await fetch(`${this.apiBaseUrl}/services?${params}`, {
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': this.authToken,
            },
        });

        if (!response.ok) throw new Error('Erreur chargement services');

        const data = await response.json();
        
        // Stocker les services et leurs options
        data.data.forEach(service => {
            this.services.set(service.id, service);
            this.serviceOptions.set(service.id, service.options || []);
        });

        return data.data;
    }

    /**
     * Ajouter un service au panier
     */
    addService(serviceId, quantity = 1) {
        const service = this.services.get(serviceId);
        if (!service) {
            console.error('Service non trouvé:', serviceId);
            return;
        }

        // Vérifier si le service est déjà dans le panier
        const existingIndex = this.cart.findIndex(item => item.service_id === serviceId);
        
        if (existingIndex >= 0) {
            // Augmenter la quantité
            this.cart[existingIndex].quantity += quantity;
        } else {
            // Ajouter un nouvel item
            this.cart.push({
                service_id: serviceId,
                service_name: service.name,
                service_price: service.price,
                service_duration: service.duration,
                quantity: quantity,
                staff_id: null,
                notes: '',
                options: [],
            });
        }

        this.renderCart();
        this.showServiceOptions(serviceId);
    }

    /**
     * Supprimer un service du panier
     */
    removeService(index) {
        if (index >= 0 && index < this.cart.length) {
            this.cart.splice(index, 1);
            this.renderCart();
            this.calculateTotals();
        }
    }

    /**
     * Mettre à jour la quantité d'un service
     */
    updateServiceQuantity(index, quantity) {
        if (index >= 0 && index < this.cart.length) {
            this.cart[index].quantity = Math.max(1, parseInt(quantity) || 1);
            this.renderCart();
            this.calculateTotals();
        }
    }

    /**
     * Ajouter une option à un item du panier
     */
    addOptionToItem(itemIndex, optionId, quantity = 1) {
        if (itemIndex < 0 || itemIndex >= this.cart.length) return;

        const item = this.cart[itemIndex];
        const option = this.serviceOptions.get(item.service_id)?.find(opt => opt.id === optionId);
        
        if (!option) {
            console.error('Option non trouvée:', optionId);
            return;
        }

        // Vérifier si l'option existe déjà
        const existingOption = item.options.find(opt => opt.option_id === optionId);
        
        if (existingOption) {
            // Augmenter la quantité si autorisé
            const newQuantity = existingOption.quantity + quantity;
            if (newQuantity <= option.max_quantity) {
                existingOption.quantity = newQuantity;
            } else {
                this.showError(`Quantité maximale atteinte pour ${option.name} (max: ${option.max_quantity})`);
                return;
            }
        } else {
            // Ajouter la nouvelle option
            item.options.push({
                option_id: optionId,
                option_name: option.name,
                option_price: option.price,
                option_duration: option.duration,
                quantity: Math.min(quantity, option.max_quantity),
                max_quantity: option.max_quantity,
            });
        }

        this.renderCart();
        this.calculateTotals();
    }

    /**
     * Supprimer une option d'un item
     */
    removeOptionFromItem(itemIndex, optionIndex) {
        if (itemIndex >= 0 && itemIndex < this.cart.length) {
            const item = this.cart[itemIndex];
            if (optionIndex >= 0 && optionIndex < item.options.length) {
                item.options.splice(optionIndex, 1);
                this.renderCart();
                this.calculateTotals();
            }
        }
    }

    /**
     * Mettre à jour la quantité d'une option
     */
    updateOptionQuantity(itemIndex, optionIndex, quantity) {
        if (itemIndex >= 0 && itemIndex < this.cart.length) {
            const item = this.cart[itemIndex];
            if (optionIndex >= 0 && optionIndex < item.options.length) {
                const option = item.options[optionIndex];
                const newQuantity = Math.max(1, Math.min(parseInt(quantity) || 1, option.max_quantity));
                option.quantity = newQuantity;
                this.renderCart();
                this.calculateTotals();
            }
        }
    }

    /**
     * Calculer les totaux via l'API
     */
    async calculateTotals() {
        if (this.cart.length === 0) {
            this.totals = { subtotal: 0, discount_total: 0, total: 0, total_duration: 0 };
            this.renderTotals();
            return;
        }

        try {
            const payload = {
                items: this.cart.map(item => ({
                    service_id: item.service_id,
                    quantity: item.quantity,
                    options: item.options.map(opt => ({
                        option_id: opt.option_id,
                        quantity: opt.quantity,
                    })),
                })),
            };

            const response = await fetch(`${this.apiBaseUrl}/bookings/calculate`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': this.authToken,
                },
                body: JSON.stringify(payload),
            });

            if (!response.ok) throw new Error('Erreur calcul totaux');

            const data = await response.json();
            this.totals = data.data;
            this.renderTotals();
        } catch (error) {
            console.error('Erreur calcul totaux:', error);
            this.showError('Impossible de calculer le total');
        }
    }

    /**
     * Créer la réservation
     */
    async createBooking(date, time, notes = '') {
        if (this.cart.length === 0) {
            this.showError('Votre panier est vide');
            return;
        }

        try {
            const payload = {
                date,
                time,
                notes,
                items: this.cart.map(item => ({
                    service_id: item.service_id,
                    staff_id: item.staff_id,
                    quantity: item.quantity,
                    notes: item.notes,
                    options: item.options.map(opt => ({
                        option_id: opt.option_id,
                        quantity: opt.quantity,
                    })),
                })),
            };

            const response = await fetch(`${this.apiBaseUrl}/bookings`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': this.authToken,
                },
                body: JSON.stringify(payload),
            });

            if (!response.ok) {
                const error = await response.json();
                throw new Error(error.message || 'Erreur création réservation');
            }

            const data = await response.json();
            
            // Réinitialiser le panier
            this.cart = [];
            this.totals = { subtotal: 0, discount_total: 0, total: 0, total_duration: 0 };
            this.renderCart();

            this.showSuccess(`Réservation créée avec succès ! Référence: ${data.data.booking_reference}`);
            
            return data.data;
        } catch (error) {
            console.error('Erreur création booking:', error);
            this.showError(error.message || 'Impossible de créer la réservation');
            throw error;
        }
    }

    /**
     * Afficher le panneau des options pour un service
     */
    showServiceOptions(serviceId) {
        const options = this.serviceOptions.get(serviceId);
        if (!options || options.length === 0) {
            // Pas d'options, calculer directement
            this.calculateTotals();
            return;
        }

        // Trouver l'index de l'item dans le panier
        const itemIndex = this.cart.findIndex(item => item.service_id === serviceId);
        if (itemIndex < 0) return;

        // Dispatcher un événement personnalisé pour l'UI
        const event = new CustomEvent('showServiceOptions', {
            detail: {
                serviceId,
                itemIndex,
                options,
                currentOptions: this.cart[itemIndex].options,
            },
        });
        document.dispatchEvent(event);
    }

    /**
     * Render le panier dans l'UI
     */
    renderCart() {
        const event = new CustomEvent('cartUpdated', {
            detail: {
                cart: this.cart,
                itemCount: this.cart.length,
            },
        });
        document.dispatchEvent(event);
    }

    /**
     * Render les totaux dans l'UI
     */
    renderTotals() {
        const event = new CustomEvent('totalsUpdated', {
            detail: this.totals,
        });
        document.dispatchEvent(event);
    }

    /**
     * Afficher un message d'erreur
     */
    showError(message) {
        const event = new CustomEvent('cartError', {
            detail: { message },
        });
        document.dispatchEvent(event);
    }

    /**
     * Afficher un message de succès
     */
    showSuccess(message) {
        const event = new CustomEvent('cartSuccess', {
            detail: { message },
        });
        document.dispatchEvent(event);
    }

    /**
     * Attacher les event listeners
     */
    attachEventListeners() {
        // Écouter les clics sur "Ajouter au panier"
        document.addEventListener('addToCart', (e) => {
            const { serviceId, quantity } = e.detail;
            this.addService(serviceId, quantity || 1);
        });

        // Écouter les clics sur "Ajouter une option"
        document.addEventListener('addOptionToCart', (e) => {
            const { itemIndex, optionId, quantity } = e.detail;
            this.addOptionToItem(itemIndex, optionId, quantity || 1);
        });

        // Écouter les demandes de création de réservation
        document.addEventListener('createBooking', async (e) => {
            const { date, time, notes } = e.detail;
            await this.createBooking(date, time, notes);
        });
    }

    /**
     * Vider le panier
     */
    clearCart() {
        this.cart = [];
        this.totals = { subtotal: 0, discount_total: 0, total: 0, total_duration: 0 };
        this.renderCart();
        this.renderTotals();
    }

    /**
     * Obtenir le contenu du panier
     */
    getCart() {
        return {
            items: this.cart,
            totals: this.totals,
        };
    }
}

// Initialiser le panier global
window.bookingCart = new BookingCart();
