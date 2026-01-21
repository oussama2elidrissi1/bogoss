export const clients = [
    {
      id: 'CL001',
      name: 'Sarah Johnson',
      email: 'sarah.j@email.com',
      phone: '+1 234 567 8901',
      joinDate: '2023-01-15',
      subscription: 'Premium',
      totalSpent: 1250,
      visits: 15,
      lastVisit: '2024-01-10',
      preferences: ['Aromatherapy', 'Hot Stone Massage'],
      notes: 'Prefers morning appointments'
    },
    {
      id: 'CL002',
      name: 'Michael Chen',
      email: 'mchen@email.com',
      phone: '+1 234 567 8902',
      joinDate: '2023-03-22',
      subscription: 'Basic',
      totalSpent: 680,
      visits: 8,
      lastVisit: '2024-01-08',
      preferences: ['Deep Tissue Massage'],
      notes: 'Athlete - focus on recovery'
    },
    {
      id: 'CL003',
      name: 'Emma Williams',
      email: 'emma.w@email.com',
      phone: '+1 234 567 8903',
      joinDate: '2023-06-10',
      subscription: 'Standard',
      totalSpent: 920,
      visits: 12,
      lastVisit: '2024-01-12',
      preferences: ['Facial Treatment', 'Manicure'],
      notes: 'Sensitive skin'
    },
    {
      id: 'CL004',
      name: 'David Martinez',
      email: 'david.m@email.com',
      phone: '+1 234 567 8904',
      joinDate: '2023-08-05',
      subscription: null,
      totalSpent: 340,
      visits: 4,
      lastVisit: '2024-01-05',
      preferences: ['Hammam'],
      notes: 'Walk-in customer'
    },
    {
      id: 'CL005',
      name: 'Lisa Anderson',
      email: 'lisa.a@email.com',
      phone: '+1 234 567 8905',
      joinDate: '2023-02-18',
      subscription: 'Premium',
      totalSpent: 1580,
      visits: 20,
      lastVisit: '2024-01-14',
      preferences: ['Full Body Massage', 'Pedicure'],
      notes: 'Regular monthly visits'
    }
  ]
  
  export const services = [
    {
      id: 'SV001',
      name: 'Classic Haircut',
      category: 'Hair Salon',
      duration: 45,
      price: 35,
      description: 'Professional haircut with styling consultation',
      image: 'https://images.unsplash.com/photo-1560066984-138dadb4c035?w=400',
      available: true
    },
    {
      id: 'SV002',
      name: 'Hair Coloring',
      category: 'Hair Salon',
      duration: 120,
      price: 85,
      description: 'Full color treatment with premium products',
      image: 'https://images.unsplash.com/photo-1522337660859-02fbefca4702?w=400',
      available: true
    },
    {
      id: 'SV003',
      name: 'Traditional Hammam',
      category: 'Hammam',
      duration: 90,
      price: 75,
      description: 'Authentic Turkish bath experience with exfoliation',
      image: 'https://images.unsplash.com/photo-1544161515-4ab6ce6db874?w=400',
      available: true
    },
    {
      id: 'SV004',
      name: 'Luxury Hammam Package',
      category: 'Hammam',
      duration: 150,
      price: 120,
      description: 'Complete hammam experience with massage and aromatherapy',
      image: 'https://images.unsplash.com/photo-1540555700478-4be289fbecef?w=400',
      available: true
    },
    {
      id: 'SV005',
      name: 'Hijama Therapy',
      category: 'Hijama',
      duration: 60,
      price: 65,
      description: 'Traditional cupping therapy for wellness',
      image: 'https://images.unsplash.com/photo-1519823551278-64ac92734fb1?w=400',
      available: true
    },
    {
      id: 'SV006',
      name: 'Full Body Hijama',
      category: 'Hijama',
      duration: 90,
      price: 95,
      description: 'Comprehensive cupping therapy session',
      image: 'https://images.unsplash.com/photo-1544161515-4ab6ce6db874?w=400',
      available: true
    },
    {
      id: 'SV007',
      name: 'Classic Manicure',
      category: 'Manicure',
      duration: 45,
      price: 30,
      description: 'Nail shaping, cuticle care, and polish',
      image: 'https://images.unsplash.com/photo-1604654894610-df63bc536371?w=400',
      available: true
    },
    {
      id: 'SV008',
      name: 'Gel Manicure',
      category: 'Manicure',
      duration: 60,
      price: 45,
      description: 'Long-lasting gel polish manicure',
      image: 'https://images.unsplash.com/photo-1610992015732-2449b76344bc?w=400',
      available: true
    },
    {
      id: 'SV009',
      name: 'Spa Pedicure',
      category: 'Pedicure',
      duration: 60,
      price: 50,
      description: 'Relaxing foot treatment with massage',
      image: 'https://images.unsplash.com/photo-1598971639058-fab3c3109a00?w=400',
      available: true
    },
    {
      id: 'SV010',
      name: 'Deluxe Pedicure',
      category: 'Pedicure',
      duration: 75,
      price: 65,
      description: 'Premium pedicure with exfoliation and hot stone massage',
      image: 'https://images.unsplash.com/photo-1607779097040-26e80aa78e66?w=400',
      available: true
    },
    {
      id: 'SV011',
      name: 'Deep Tissue Massage',
      category: 'Massage',
      duration: 60,
      price: 80,
      description: 'Therapeutic massage for muscle tension relief',
      image: 'https://images.unsplash.com/photo-1544161515-4ab6ce6db874?w=400',
      available: true
    },
    {
      id: 'SV012',
      name: 'Aromatherapy Massage',
      category: 'Massage',
      duration: 90,
      price: 95,
      description: 'Relaxing massage with essential oils',
      image: 'https://images.unsplash.com/photo-1540555700478-4be289fbecef?w=400',
      available: true
    }
  ]
  
  export const bookings = [
    {
      id: 'BK001',
      clientId: 'CL001',
      clientName: 'Sarah Johnson',
      serviceId: 'SV003',
      service: 'Traditional Hammam',
      staffId: 'ST001',
      staffName: 'Amina Hassan',
      date: '2024-01-20',
      time: '10:00',
      duration: 90,
      price: 75,
      status: 'confirmed',
      notes: 'First time client',
      createdAt: '2024-01-15T10:30:00Z'
    },
    {
      id: 'BK002',
      clientId: 'CL002',
      clientName: 'Michael Chen',
      serviceId: 'SV011',
      service: 'Deep Tissue Massage',
      staffId: 'ST003',
      staffName: 'Maria Santos',
      date: '2024-01-20',
      time: '14:00',
      duration: 60,
      price: 80,
      status: 'confirmed',
      notes: 'Focus on back and shoulders',
      createdAt: '2024-01-16T09:15:00Z'
    },
    {
      id: 'BK003',
      clientId: 'CL003',
      clientName: 'Emma Williams',
      serviceId: 'SV008',
      service: 'Gel Manicure',
      staffId: 'ST004',
      staffName: 'Sophie Laurent',
      date: '2024-01-21',
      time: '11:00',
      duration: 60,
      price: 45,
      status: 'confirmed',
      notes: 'Prefers neutral colors',
      createdAt: '2024-01-17T14:20:00Z'
    },
    {
      id: 'BK004',
      clientId: 'CL005',
      clientName: 'Lisa Anderson',
      serviceId: 'SV004',
      service: 'Luxury Hammam Package',
      staffId: 'ST001',
      staffName: 'Amina Hassan',
      date: '2024-01-21',
      time: '15:00',
      duration: 150,
      price: 120,
      status: 'confirmed',
      notes: 'Regular client - VIP treatment',
      createdAt: '2024-01-18T11:45:00Z'
    },
    {
      id: 'BK005',
      clientId: 'CL004',
      clientName: 'David Martinez',
      serviceId: 'SV001',
      service: 'Classic Haircut',
      staffId: 'ST002',
      staffName: 'Jean-Pierre Dubois',
      date: '2024-01-22',
      time: '09:30',
      duration: 45,
      price: 35,
      status: 'pending',
      notes: 'Walk-in appointment',
      createdAt: '2024-01-19T16:00:00Z'
    }
  ]
  
  export const staff = [
    {
      id: 'ST001',
      name: 'Amina Hassan',
      role: 'Hammam Specialist',
      specialties: ['Traditional Hammam', 'Luxury Hammam Package', 'Body Treatments'],
      email: 'amina.h@bogosland.com',
      phone: '+1 234 567 9001',
      joinDate: '2022-03-15',
      rating: 4.9,
      completedServices: 450,
      availability: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
      image: 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=200'
    },
    {
      id: 'ST002',
      name: 'Jean-Pierre Dubois',
      role: 'Master Hair Stylist',
      specialties: ['Haircut', 'Hair Coloring', 'Hair Styling'],
      email: 'jean.p@bogosland.com',
      phone: '+1 234 567 9002',
      joinDate: '2021-06-20',
      rating: 4.8,
      completedServices: 680,
      availability: ['Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
      image: 'https://images.unsplash.com/photo-1560250097-0b93528c311a?w=200'
    },
    {
      id: 'ST003',
      name: 'Maria Santos',
      role: 'Massage Therapist',
      specialties: ['Deep Tissue Massage', 'Aromatherapy Massage', 'Sports Massage'],
      email: 'maria.s@bogosland.com',
      phone: '+1 234 567 9003',
      joinDate: '2022-01-10',
      rating: 4.9,
      completedServices: 520,
      availability: ['Monday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
      image: 'https://images.unsplash.com/photo-1594744803329-e58b31de8bf5?w=200'
    },
    {
      id: 'ST004',
      name: 'Sophie Laurent',
      role: 'Nail Technician',
      specialties: ['Manicure', 'Pedicure', 'Gel Nails', 'Nail Art'],
      email: 'sophie.l@bogosland.com',
      phone: '+1 234 567 9004',
      joinDate: '2022-08-05',
      rating: 4.7,
      completedServices: 380,
      availability: ['Monday', 'Tuesday', 'Thursday', 'Friday', 'Saturday'],
      image: 'https://images.unsplash.com/photo-1580489944761-15a19d654956?w=200'
    },
    {
      id: 'ST005',
      name: 'Dr. Ahmed Al-Rashid',
      role: 'Hijama Specialist',
      specialties: ['Hijama Therapy', 'Full Body Hijama', 'Wellness Consultation'],
      email: 'ahmed.r@bogosland.com',
      phone: '+1 234 567 9005',
      joinDate: '2021-11-12',
      rating: 5.0,
      completedServices: 310,
      availability: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday'],
      image: 'https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?w=200'
    }
  ]
  
  export const inventory = [
    {
      id: 'INV001',
      name: 'Moroccan Black Soap',
      category: 'Hammam Products',
      quantity: 45,
      minQuantity: 20,
      unit: 'bottles',
      price: 18,
      supplier: 'Atlas Wellness Supplies',
      lastRestocked: '2024-01-10',
      status: 'in-stock'
    },
    {
      id: 'INV002',
      name: 'Argan Oil',
      category: 'Hair Care',
      quantity: 12,
      minQuantity: 15,
      unit: 'bottles',
      price: 35,
      supplier: 'Moroccan Beauty Co',
      lastRestocked: '2023-12-28',
      status: 'low-stock'
    },
    {
      id: 'INV003',
      name: 'Eucalyptus Essential Oil',
      category: 'Aromatherapy',
      quantity: 28,
      minQuantity: 10,
      unit: 'bottles',
      price: 22,
      supplier: 'Pure Essence Ltd',
      lastRestocked: '2024-01-08',
      status: 'in-stock'
    },
    {
      id: 'INV004',
      name: 'Gel Polish Set',
      category: 'Nail Care',
      quantity: 8,
      minQuantity: 12,
      unit: 'sets',
      price: 45,
      supplier: 'Professional Nails Inc',
      lastRestocked: '2023-12-20',
      status: 'low-stock'
    },
    {
      id: 'INV005',
      name: 'Cupping Set',
      category: 'Hijama Equipment',
      quantity: 15,
      minQuantity: 8,
      unit: 'sets',
      price: 65,
      supplier: 'Medical Wellness Supply',
      lastRestocked: '2024-01-05',
      status: 'in-stock'
    },
    {
      id: 'INV006',
      name: 'Massage Oil - Lavender',
      category: 'Massage',
      quantity: 32,
      minQuantity: 20,
      unit: 'bottles',
      price: 28,
      supplier: 'Pure Essence Ltd',
      lastRestocked: '2024-01-12',
      status: 'in-stock'
    },
    {
      id: 'INV007',
      name: 'Exfoliating Glove',
      category: 'Hammam Products',
      quantity: 5,
      minQuantity: 15,
      unit: 'pieces',
      price: 8,
      supplier: 'Atlas Wellness Supplies',
      lastRestocked: '2023-12-15',
      status: 'critical'
    },
    {
      id: 'INV008',
      name: 'Hair Color Kit',
      category: 'Hair Care',
      quantity: 22,
      minQuantity: 10,
      unit: 'kits',
      price: 42,
      supplier: 'Professional Hair Solutions',
      lastRestocked: '2024-01-14',
      status: 'in-stock'
    }
  ]
  
  export const subscriptions = [
    {
      id: 'SUB001',
      name: 'Basic',
      price: 49,
      duration: 'monthly',
      benefits: [
        '10% discount on all services',
        '1 free classic service per month',
        'Priority booking',
        'Birthday special offer'
      ],
      color: 'primary',
      popular: false
    },
    {
      id: 'SUB002',
      name: 'Standard',
      price: 89,
      duration: 'monthly',
      benefits: [
        '15% discount on all services',
        '2 free services per month',
        'Priority booking',
        'Free product samples',
        'Birthday special offer',
        'Exclusive member events'
      ],
      color: 'secondary',
      popular: true
    },
    {
      id: 'SUB003',
      name: 'Premium',
      price: 149,
      duration: 'monthly',
      benefits: [
        '25% discount on all services',
        '3 free premium services per month',
        'VIP priority booking',
        'Free product samples',
        'Complimentary wellness consultation',
        'Birthday luxury package',
        'Exclusive member events',
        'Bring a friend discount'
      ],
      color: 'accent',
      popular: false
    }
  ]
  
  export const products = [
    {
      id: 'PRD001',
      name: 'Argan Oil Hair Serum',
      category: 'Hair Care',
      price: 45,
      image: 'https://images.unsplash.com/photo-1608248543803-ba4f8c70ae0b?w=400',
      description: 'Premium argan oil for silky smooth hair',
      inStock: true,
      rating: 4.8
    },
    {
      id: 'PRD002',
      name: 'Moroccan Black Soap',
      category: 'Body Care',
      price: 25,
      image: 'https://images.unsplash.com/photo-1556228578-8c89e6adf883?w=400',
      description: 'Traditional hammam black soap for deep cleansing',
      inStock: true,
      rating: 4.9
    },
    {
      id: 'PRD003',
      name: 'Lavender Essential Oil',
      category: 'Aromatherapy',
      price: 32,
      image: 'https://images.unsplash.com/photo-1608571423902-eed4a5ad8108?w=400',
      description: 'Pure lavender oil for relaxation and wellness',
      inStock: true,
      rating: 4.7
    },
    {
      id: 'PRD004',
      name: 'Luxury Hand Cream Set',
      category: 'Hand Care',
      price: 38,
      image: 'https://images.unsplash.com/photo-1556228852-80a5a1e11a2f?w=400',
      description: 'Set of 3 nourishing hand creams',
      inStock: true,
      rating: 4.6
    },
    {
      id: 'PRD005',
      name: 'Exfoliating Body Scrub',
      category: 'Body Care',
      price: 28,
      image: 'https://images.unsplash.com/photo-1570554886111-e80fcca6a029?w=400',
      description: 'Natural body scrub with sea salt and oils',
      inStock: false,
      rating: 4.5
    },
    {
      id: 'PRD006',
      name: 'Rose Water Toner',
      category: 'Skincare',
      price: 22,
      image: 'https://images.unsplash.com/photo-1620916566398-39f1143ab7be?w=400',
      description: 'Refreshing rose water facial toner',
      inStock: true,
      rating: 4.8
    }
  ]
  
  export const promotions = [
    {
      id: 'PROMO001',
      title: 'New Year Wellness Package',
      description: '20% off all hammam services',
      discount: 20,
      type: 'percentage',
      validFrom: '2024-01-01',
      validUntil: '2024-01-31',
      applicableServices: ['SV003', 'SV004'],
      status: 'active',
      code: 'NEWYEAR2024'
    },
    {
      id: 'PROMO002',
      title: 'Manicure & Pedicure Combo',
      description: 'Get both services for $85 (save $10)',
      discount: 10,
      type: 'fixed',
      validFrom: '2024-01-15',
      validUntil: '2024-02-15',
      applicableServices: ['SV007', 'SV009'],
      status: 'active',
      code: 'NAILCOMBO'
    },
    {
      id: 'PROMO003',
      title: 'First Time Client Special',
      description: '15% off your first service',
      discount: 15,
      type: 'percentage',
      validFrom: '2024-01-01',
      validUntil: '2024-12-31',
      applicableServices: 'all',
      status: 'active',
      code: 'WELCOME15'
    },
    {
      id: 'PROMO004',
      title: 'Massage Monday',
      description: '$15 off all massage services on Mondays',
      discount: 15,
      type: 'fixed',
      validFrom: '2024-01-01',
      validUntil: '2024-03-31',
      applicableServices: ['SV011', 'SV012'],
      status: 'active',
      code: 'MASSAGEMON'
    }
  ]