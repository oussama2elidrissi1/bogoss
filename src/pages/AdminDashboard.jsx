import { motion } from 'framer-motion'
import { Users, Calendar, DollarSign, TrendingUp, Package, UserCheck } from 'lucide-react'
import { useApp } from '../context/AppContext'
import { Link } from 'react-router-dom'
import StatCard from '../components/StatCard'

const AdminDashboard = () => {
  const { clientsData, bookingsData, inventoryData, servicesData } = useApp()

  const totalRevenue = bookingsData.reduce((sum, b) => sum + b.price, 0)
  const todayBookings = bookingsData.filter(b => {
    const today = new Date().toDateString()
    return new Date(b.date).toDateString() === today
  }).length

  const lowStockItems = inventoryData.filter(item => 
    item.quantity <= item.minQuantity
  ).length

  const recentBookings = bookingsData.slice(-5).reverse()

  const stats = [
    {
      icon: Users,
      label: 'Total Clients',
      value: clientsData.length,
      trend: { type: 'up', value: 12 },
      color: 'primary'
    },
    {
      icon: Calendar,
      label: "Today's Bookings",
      value: todayBookings,
      color: 'secondary'
    },
    {
      icon: DollarSign,
      label: 'Total Revenue',
      value: `$${totalRevenue.toLocaleString()}`,
      trend: { type: 'up', value: 8 },
      color: 'accent'
    },
    {
      icon: Package,
      label: 'Low Stock Items',
      value: lowStockItems,
      color: lowStockItems > 0 ? 'warning' : 'success'
    }
  ]

  return (
    <div className="min-h-screen bg-gradient-to-b from-white to-gray-50">
      <section className="gradient-wellness py-16">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <motion.div
            initial={{ opacity: 0, y: 20 }}
            animate={{ opacity: 1, y: 0 }}
            className="text-white"
          >
            <h1 className="font-serif text-4xl font-bold mb-2">Admin Dashboard</h1>
            <p className="text-xl">Overview of your wellness center operations</p>
          </motion.div>
        </div>
      </section>

      <section className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
          {stats.map((stat, index) => (
            <motion.div
              key={index}
              initial={{ opacity: 0, y: 20 }}
              animate={{ opacity: 1, y: 0 }}
              transition={{ delay: index * 0.1 }}
            >
              <StatCard {...stat} />
            </motion.div>
          ))}
        </div>

        <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
          <div className="lg:col-span-2">
            <motion.div
              initial={{ opacity: 0, y: 20 }}
              animate={{ opacity: 1, y: 0 }}
              transition={{ delay: 0.4 }}
              className="glass-card p-6"
            >
              <div className="flex justify-between items-center mb-6">
                <h2 className="font-serif text-2xl font-bold text-gray-900">
                  Recent Bookings
                </h2>
                <Link to="/admin/bookings" className="text-primary hover:underline text-sm font-medium">
                  View All
                </Link>
              </div>
              <div className="space-y-3">
                {recentBookings.map(booking => (
                  <div key={booking.id} className="bg-gray-50 rounded-lg p-4">
                    <div className="flex justify-between items-start mb-2">
                      <div>
                        <h3 className="font-bold text-gray-900">{booking.clientName}</h3>
                        <p className="text-sm text-gray-600">{booking.service}</p>
                      </div>
                      <span className={`badge ${
                        booking.status === 'confirmed' ? 'badge-success' :
                        booking.status === 'pending' ? 'badge-warning' :
                        'badge-error'
                      }`}>
                        {booking.status}
                      </span>
                    </div>
                    <div className="flex items-center space-x-4 text-sm text-gray-600">
                      <span>📅 {new Date(booking.date).toLocaleDateString()}</span>
                      <span>🕐 {booking.time}</span>
                      <span>💰 ${booking.price}</span>
                    </div>
                  </div>
                ))}
              </div>
            </motion.div>
          </div>

          <div className="space-y-6">
            <motion.div
              initial={{ opacity: 0, y: 20 }}
              animate={{ opacity: 1, y: 0 }}
              transition={{ delay: 0.5 }}
              className="glass-card p-6"
            >
              <h3 className="font-serif text-xl font-bold text-gray-900 mb-4">
                Quick Actions
              </h3>
              <div className="space-y-2">
                <Link
                  to="/admin/bookings"
                  className="w-full text-left px-4 py-3 bg-gray-50 hover:bg-gray-100 rounded-lg transition-colors flex items-center space-x-3"
                >
                  <Calendar size={20} className="text-primary" />
                  <span>Manage Bookings</span>
                </Link>
                <Link
                  to="/admin/clients"
                  className="w-full text-left px-4 py-3 bg-gray-50 hover:bg-gray-100 rounded-lg transition-colors flex items-center space-x-3"
                >
                  <Users size={20} className="text-primary" />
                  <span>View Clients</span>
                </Link>
                <Link
                  to="/admin/staff"
                  className="w-full text-left px-4 py-3 bg-gray-50 hover:bg-gray-100 rounded-lg transition-colors flex items-center space-x-3"
                >
                  <UserCheck size={20} className="text-primary" />
                  <span>Manage Staff</span>
                </Link>
                <Link
                  to="/admin/inventory"
                  className="w-full text-left px-4 py-3 bg-gray-50 hover:bg-gray-100 rounded-lg transition-colors flex items-center space-x-3"
                >
                  <Package size={20} className="text-primary" />
                  <span>Check Inventory</span>
                </Link>
              </div>
            </motion.div>

            <motion.div
              initial={{ opacity: 0, y: 20 }}
              animate={{ opacity: 1, y: 0 }}
              transition={{ delay: 0.6 }}
              className="glass-card p-6"
            >
              <h3 className="font-serif text-xl font-bold text-gray-900 mb-4">
                Popular Services
              </h3>
              <div className="space-y-3">
                {servicesData.slice(0, 4).map(service => (
                  <div key={service.id} className="flex justify-between items-center">
                    <span className="text-sm text-gray-700">{service.name}</span>
                    <span className="text-sm font-bold text-primary">${service.price}</span>
                  </div>
                ))}
              </div>
            </motion.div>
          </div>
        </div>
      </section>
    </div>
  )
}

export default AdminDashboard