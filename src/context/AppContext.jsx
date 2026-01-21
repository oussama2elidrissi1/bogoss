import { createContext, useContext, useState, useEffect } from 'react'
import api from '../config/api'

const AppContext = createContext()

export const useApp = () => {
  const context = useContext(AppContext)
  if (!context) {
    throw new Error('useApp must be used within AppProvider')
  }
  return context
}

export const AppProvider = ({ children }) => {
  const [currentUser, setCurrentUser] = useState(null)
  const [isAdmin, setIsAdmin] = useState(false)
  const [clientsData, setClientsData] = useState([])
  const [servicesData, setServicesData] = useState([])
  const [bookingsData, setBookingsData] = useState([])
  const [staffData, setStaffData] = useState([])
  const [inventoryData, setInventoryData] = useState([])
  const [subscriptionsData, setSubscriptionsData] = useState([])
  const [productsData, setProductsData] = useState([])
  const [promotionsData, setPromotionsData] = useState([])
  const [cart, setCart] = useState([])
  const [notifications, setNotifications] = useState([])
  const [loading, setLoading] = useState(true)

  useEffect(() => {
    const token = localStorage.getItem('auth_token')
    const user = localStorage.getItem('currentUser')
    const adminStatus = localStorage.getItem('isAdmin')
    
    if (token && user) {
      setCurrentUser(JSON.parse(user))
      setIsAdmin(adminStatus === 'true')
      loadData()
    } else {
      setLoading(false)
    }
  }, [])

  const loadData = async () => {
    try {
      setLoading(true)
      const [clients, services, bookings, staff, inventory, subscriptions, products, promotions] = await Promise.all([
        api.get('/clients').catch(() => []),
        api.get('/services').catch(() => []),
        api.get('/bookings').catch(() => []),
        api.get('/staff').catch(() => []),
        api.get('/inventory').catch(() => []),
        api.get('/subscriptions').catch(() => []),
        api.get('/products').catch(() => []),
        api.get('/promotions').catch(() => []),
      ])

      setClientsData(clients)
      setServicesData(services)
      setBookingsData(bookings)
      setStaffData(staff)
      setInventoryData(inventory)
      setSubscriptionsData(subscriptions)
      setProductsData(products)
      setPromotionsData(promotions)
    } catch (error) {
      console.error('Error loading data:', error)
    } finally {
      setLoading(false)
    }
  }

  const login = async (email, password, admin = false) => {
    try {
      const response = await api.post('/login', { email, password })
      
      if (response.user) {
        setCurrentUser(response.user)
        setIsAdmin(response.is_admin || false)
        localStorage.setItem('auth_token', response.token)
        localStorage.setItem('currentUser', JSON.stringify(response.user))
        localStorage.setItem('isAdmin', response.is_admin ? 'true' : 'false')
        
        await loadData()
        return { success: true, user: response.user }
      }
      
      return { success: false, message: 'Invalid credentials' }
    } catch (error) {
      return { success: false, message: error.message || 'Login failed' }
    }
  }

  const logout = async () => {
    try {
      await api.post('/logout')
    } catch (error) {
      console.error('Logout error:', error)
    } finally {
      setCurrentUser(null)
      setIsAdmin(false)
      localStorage.removeItem('auth_token')
      localStorage.removeItem('currentUser')
      localStorage.removeItem('isAdmin')
      setClientsData([])
      setServicesData([])
      setBookingsData([])
      setStaffData([])
      setInventoryData([])
      setSubscriptionsData([])
      setProductsData([])
      setPromotionsData([])
    }
  }

  const addBooking = async (booking) => {
    try {
      const newBooking = await api.post('/bookings', booking)
      setBookingsData(prev => [...prev, newBooking])
      addNotification({
        type: 'success',
        message: `Booking confirmed for ${booking.service} on ${booking.date}`,
        timestamp: new Date().toISOString()
      })
      return newBooking
    } catch (error) {
      console.error('Error adding booking:', error)
      throw error
    }
  }

  const updateBooking = async (id, updates) => {
    try {
      const updated = await api.put(`/bookings/${id}`, updates)
      setBookingsData(prev => prev.map(b => b.id === id ? updated : b))
      return updated
    } catch (error) {
      console.error('Error updating booking:', error)
      throw error
    }
  }

  const deleteBooking = async (id) => {
    try {
      await api.delete(`/bookings/${id}`)
      setBookingsData(prev => prev.filter(b => b.id !== id))
    } catch (error) {
      console.error('Error deleting booking:', error)
      throw error
    }
  }

  const addClient = async (client) => {
    try {
      const newClient = await api.post('/clients', client)
      setClientsData(prev => [...prev, newClient])
      return newClient
    } catch (error) {
      console.error('Error adding client:', error)
      throw error
    }
  }

  const updateClient = async (id, updates) => {
    try {
      const updated = await api.put(`/clients/${id}`, updates)
      setClientsData(prev => prev.map(c => c.id === id ? updated : c))
      return updated
    } catch (error) {
      console.error('Error updating client:', error)
      throw error
    }
  }

  const deleteClient = async (id) => {
    try {
      await api.delete(`/clients/${id}`)
      setClientsData(prev => prev.filter(c => c.id !== id))
    } catch (error) {
      console.error('Error deleting client:', error)
      throw error
    }
  }

  const addStaff = async (member) => {
    try {
      const newStaff = await api.post('/staff', member)
      setStaffData(prev => [...prev, newStaff])
      return newStaff
    } catch (error) {
      console.error('Error adding staff:', error)
      throw error
    }
  }

  const updateStaff = async (id, updates) => {
    try {
      const updated = await api.put(`/staff/${id}`, updates)
      setStaffData(prev => prev.map(s => s.id === id ? updated : s))
      return updated
    } catch (error) {
      console.error('Error updating staff:', error)
      throw error
    }
  }

  const deleteStaff = async (id) => {
    try {
      await api.delete(`/staff/${id}`)
      setStaffData(prev => prev.filter(s => s.id !== id))
    } catch (error) {
      console.error('Error deleting staff:', error)
      throw error
    }
  }

  const updateInventory = async (id, updates) => {
    try {
      const updated = await api.put(`/inventory/${id}`, updates)
      setInventoryData(prev => prev.map(i => i.id === id ? updated : i))
      return updated
    } catch (error) {
      console.error('Error updating inventory:', error)
      throw error
    }
  }

  const addPromotion = async (promo) => {
    try {
      const newPromo = await api.post('/promotions', promo)
      setPromotionsData(prev => [...prev, newPromo])
      return newPromo
    } catch (error) {
      console.error('Error adding promotion:', error)
      throw error
    }
  }

  const updatePromotion = async (id, updates) => {
    try {
      const updated = await api.put(`/promotions/${id}`, updates)
      setPromotionsData(prev => prev.map(p => p.id === id ? updated : p))
      return updated
    } catch (error) {
      console.error('Error updating promotion:', error)
      throw error
    }
  }

  const deletePromotion = async (id) => {
    try {
      await api.delete(`/promotions/${id}`)
      setPromotionsData(prev => prev.filter(p => p.id !== id))
    } catch (error) {
      console.error('Error deleting promotion:', error)
      throw error
    }
  }

  const addToCart = (product) => {
    setCart(prev => {
      const existing = prev.find(item => item.id === product.id)
      if (existing) {
        return prev.map(item => 
          item.id === product.id 
            ? { ...item, quantity: item.quantity + 1 }
            : item
        )
      }
      return [...prev, { ...product, quantity: 1 }]
    })
  }

  const removeFromCart = (productId) => {
    setCart(prev => prev.filter(item => item.id !== productId))
  }

  const updateCartQuantity = (productId, quantity) => {
    if (quantity <= 0) {
      removeFromCart(productId)
      return
    }
    setCart(prev => prev.map(item => 
      item.id === productId ? { ...item, quantity } : item
    ))
  }

  const clearCart = () => {
    setCart([])
  }

  const addNotification = (notification) => {
    const newNotification = {
      ...notification,
      id: `NT${Date.now()}`,
      read: false
    }
    setNotifications(prev => [newNotification, ...prev])
  }

  const markNotificationRead = (id) => {
    setNotifications(prev => prev.map(n => n.id === id ? { ...n, read: true } : n))
  }

  const clearNotifications = () => {
    setNotifications([])
  }

  const value = {
    currentUser,
    isAdmin,
    clientsData,
    servicesData,
    bookingsData,
    staffData,
    inventoryData,
    subscriptionsData,
    productsData,
    promotionsData,
    cart,
    notifications,
    loading,
    login,
    logout,
    addBooking,
    updateBooking,
    deleteBooking,
    addClient,
    updateClient,
    deleteClient,
    addStaff,
    updateStaff,
    deleteStaff,
    updateInventory,
    addPromotion,
    updatePromotion,
    deletePromotion,
    addToCart,
    removeFromCart,
    updateCartQuantity,
    clearCart,
    addNotification,
    markNotificationRead,
    clearNotifications,
    loadData,
  }

  return <AppContext.Provider value={value}>{children}</AppContext.Provider>
}
