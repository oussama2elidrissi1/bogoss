import { motion } from 'framer-motion'
import { TrendingUp, Users, Calendar, DollarSign, ShoppingBag, Star } from 'lucide-react'
import { useApp } from '../context/AppContext'

const AdminAnalytics = () => {
  const { bookingsData, clientsData, servicesData, productsData, staffData } = useApp()

  // Calculate statistics
  const totalRevenue = bookingsData.reduce((sum, booking) => sum + booking.price, 0)
  const totalBookings = bookingsData.length
  const totalClients = clientsData.length
  const totalServices = servicesData.length
  const averageBookingValue = totalBookings > 0 ? (totalRevenue / totalBookings).toFixed(2) : 0
  const activeStaff = staffData.length

  // Get recent bookings
  const recentBookings = bookingsData
    .sort((a, b) => new Date(b.createdAt) - new Date(a.createdAt))
    .slice(0, 5)

  // Get top services
  const serviceCounts = {}
  bookingsData.forEach(booking => {
    serviceCounts[booking.service] = (serviceCounts[booking.service] || 0) + 1
  })
  const topServices = Object.entries(serviceCounts)
    .sort((a, b) => b[1] - a[1])
    .slice(0, 5)

  const stats = [
    {
      label: 'Total Revenue',
      value: `$${totalRevenue.toLocaleString()}`,
      icon: DollarSign,
      color: 'text-green-600',
      bgColor: 'bg-green-50'
    },
    {
      label: 'Total Bookings',
      value: totalBookings,
      icon: Calendar,
      color: 'text-blue-600',
      bgColor: 'bg-blue-50'
    },
    {
      label: 'Total Clients',
      value: totalClients,
      icon: Users,
      color: 'text-purple-600',
      bgColor: 'bg-purple-50'
    },
    {
      label: 'Active Services',
      value: totalServices,
      icon: ShoppingBag,
      color: 'text-orange-600',
      bgColor: 'bg-orange-50'
    },
    {
      label: 'Average Booking',
      value: `$${averageBookingValue}`,
      icon: TrendingUp,
      color: 'text-indigo-600',
      bgColor: 'bg-indigo-50'
    },
    {
      label: 'Staff Members',
      value: activeStaff,
      icon: Star,
      color: 'text-pink-600',
      bgColor: 'bg-pink-50'
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
            <h1 className="font-serif text-4xl font-bold mb-2">Analytics Dashboard</h1>
            <p className="text-xl">Business insights and performance metrics</p>
          </motion.div>
        </div>
      </section>

      <section className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        {/* Statistics Grid */}
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
          {stats.map((stat, index) => {
            const Icon = stat.icon
            return (
              <motion.div
                key={stat.label}
                initial={{ opacity: 0, y: 20 }}
                animate={{ opacity: 1, y: 0 }}
                transition={{ delay: index * 0.1 }}
                className="glass-card p-6"
              >
                <div className="flex items-center justify-between">
                  <div>
                    <p className="text-sm text-gray-600 mb-1">{stat.label}</p>
                    <p className="text-2xl font-bold text-gray-900">{stat.value}</p>
                  </div>
                  <div className={`${stat.bgColor} p-3 rounded-lg`}>
                    <Icon className={stat.color} size={24} />
                  </div>
                </div>
              </motion.div>
            )
          })}
        </div>

        <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
          {/* Recent Bookings */}
          <motion.div
            initial={{ opacity: 0, y: 20 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ delay: 0.3 }}
            className="glass-card p-6"
          >
            <h2 className="font-serif text-2xl font-bold text-gray-900 mb-4">Recent Bookings</h2>
            <div className="space-y-4">
              {recentBookings.length > 0 ? (
                recentBookings.map((booking) => (
                  <div
                    key={booking.id}
                    className="flex items-center justify-between p-4 bg-gray-50 rounded-lg"
                  >
                    <div>
                      <p className="font-medium text-gray-900">{booking.service}</p>
                      <p className="text-sm text-gray-600">{booking.clientName}</p>
                      <p className="text-xs text-gray-500">
                        {new Date(booking.date).toLocaleDateString()} at {booking.time}
                      </p>
                    </div>
                    <div className="text-right">
                      <p className="font-bold text-primary">${booking.price}</p>
                      <span className={`badge ${
                        booking.status === 'confirmed' ? 'badge-success' : 'badge-error'
                      }`}>
                        {booking.status}
                      </span>
                    </div>
                  </div>
                ))
              ) : (
                <p className="text-gray-500 text-center py-8">No bookings yet</p>
              )}
            </div>
          </motion.div>

          {/* Top Services */}
          <motion.div
            initial={{ opacity: 0, y: 20 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ delay: 0.4 }}
            className="glass-card p-6"
          >
            <h2 className="font-serif text-2xl font-bold text-gray-900 mb-4">Top Services</h2>
            <div className="space-y-4">
              {topServices.length > 0 ? (
                topServices.map(([service, count], index) => (
                  <div
                    key={service}
                    className="flex items-center justify-between p-4 bg-gray-50 rounded-lg"
                  >
                    <div className="flex items-center space-x-3">
                      <div className={`w-8 h-8 rounded-full flex items-center justify-center font-bold text-white ${
                        index === 0 ? 'bg-yellow-500' :
                        index === 1 ? 'bg-gray-400' :
                        index === 2 ? 'bg-orange-600' : 'bg-gray-300'
                      }`}>
                        {index + 1}
                      </div>
                      <div>
                        <p className="font-medium text-gray-900">{service}</p>
                        <p className="text-sm text-gray-600">{count} bookings</p>
                      </div>
                    </div>
                  </div>
                ))
              ) : (
                <p className="text-gray-500 text-center py-8">No service data available</p>
              )}
            </div>
          </motion.div>
        </div>
      </section>
    </div>
  )
}

export default AdminAnalytics
