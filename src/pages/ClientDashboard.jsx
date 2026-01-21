import { useState } from 'react'
import { motion } from 'framer-motion'
import { User, Calendar, CreditCard, Bell, LogIn } from 'lucide-react'
import { useApp } from '../context/AppContext'
import { useNavigate } from 'react-router-dom'

const ClientDashboard = () => {
  const { currentUser, login, bookingsData } = useApp()
  const navigate = useNavigate()
  const [loginForm, setLoginForm] = useState({ email: '', password: '' })
  const [error, setError] = useState('')

  const handleLogin = (e) => {
    e.preventDefault()
    const result = login(loginForm.email, loginForm.password, false)
    if (result.success) {
      setError('')
    } else {
      setError(result.message)
    }
  }

  const userBookings = currentUser
    ? bookingsData.filter(b => b.clientId === currentUser.id)
    : []

  const upcomingBookings = userBookings.filter(b => {
    const bookingDate = new Date(b.date)
    return bookingDate >= new Date() && b.status === 'confirmed'
  })

  if (!currentUser) {
    return (
      <div className="min-h-screen bg-gradient-to-b from-white to-gray-50 flex items-center justify-center p-4">
        <motion.div
          initial={{ opacity: 0, y: 20 }}
          animate={{ opacity: 1, y: 0 }}
          className="glass-card max-w-md w-full p-8"
        >
          <div className="text-center mb-6">
            <div className="w-16 h-16 gradient-wellness rounded-full flex items-center justify-center mx-auto mb-4">
              <LogIn size={32} className="text-white" />
            </div>
            <h2 className="font-serif text-3xl font-bold text-gray-900 mb-2">
              Client Login
            </h2>
            <p className="text-gray-600">
              Access your appointments and account details
            </p>
          </div>

          <form onSubmit={handleLogin} className="space-y-4">
            <div>
              <label className="block text-sm font-medium text-gray-700 mb-2">
                Email Address
              </label>
              <input
                type="email"
                value={loginForm.email}
                onChange={(e) => setLoginForm({ ...loginForm, email: e.target.value })}
                required
                className="input-field"
                placeholder="your.email@example.com"
              />
            </div>
            <div>
              <label className="block text-sm font-medium text-gray-700 mb-2">
                Password
              </label>
              <input
                type="password"
                value={loginForm.password}
                onChange={(e) => setLoginForm({ ...loginForm, password: e.target.value })}
                required
                className="input-field"
                placeholder="••••••••"
              />
            </div>
            {error && (
              <div className="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm">
                {error}
              </div>
            )}
            <button type="submit" className="w-full btn-primary">
              Sign In
            </button>
          </form>

          <div className="mt-6 text-center">
            <p className="text-sm text-gray-600 mb-4">
              Demo Credentials:
            </p>
            <div className="bg-gray-50 rounded-lg p-3 text-sm">
              <p className="font-mono">Email: sarah.j@email.com</p>
              <p className="font-mono">Password: any</p>
            </div>
          </div>
        </motion.div>
      </div>
    )
  }

  return (
    <div className="min-h-screen bg-gradient-to-b from-white to-gray-50">
      <section className="gradient-wellness py-16">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <motion.div
            initial={{ opacity: 0, y: 20 }}
            animate={{ opacity: 1, y: 0 }}
            className="text-white"
          >
            <h1 className="font-serif text-4xl font-bold mb-2">
              Welcome back, {currentUser.name}!
            </h1>
            <p className="text-xl">Manage your appointments and account</p>
          </motion.div>
        </div>
      </section>

      <section className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div className="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
          <motion.div
            initial={{ opacity: 0, y: 20 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ delay: 0.1 }}
            className="glass-card p-6"
          >
            <div className="flex items-center space-x-4">
              <div className="w-12 h-12 gradient-primary rounded-full flex items-center justify-center">
                <Calendar size={24} className="text-white" />
              </div>
              <div>
                <p className="text-gray-600 text-sm">Upcoming Bookings</p>
                <p className="text-3xl font-bold text-gray-900">{upcomingBookings.length}</p>
              </div>
            </div>
          </motion.div>

          <motion.div
            initial={{ opacity: 0, y: 20 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ delay: 0.2 }}
            className="glass-card p-6"
          >
            <div className="flex items-center space-x-4">
              <div className="w-12 h-12 gradient-secondary rounded-full flex items-center justify-center">
                <User size={24} className="text-white" />
              </div>
              <div>
                <p className="text-gray-600 text-sm">Total Visits</p>
                <p className="text-3xl font-bold text-gray-900">{currentUser.visits || 0}</p>
              </div>
            </div>
          </motion.div>

          <motion.div
            initial={{ opacity: 0, y: 20 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ delay: 0.3 }}
            className="glass-card p-6"
          >
            <div className="flex items-center space-x-4">
              <div className="w-12 h-12 gradient-accent rounded-full flex items-center justify-center">
                <CreditCard size={24} className="text-white" />
              </div>
              <div>
                <p className="text-gray-600 text-sm">Total Spent</p>
                <p className="text-3xl font-bold text-gray-900">${currentUser.totalSpent || 0}</p>
              </div>
            </div>
          </motion.div>
        </div>

        <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
          <div className="lg:col-span-2">
            <motion.div
              initial={{ opacity: 0, y: 20 }}
              animate={{ opacity: 1, y: 0 }}
              transition={{ delay: 0.4 }}
              className="glass-card p-6"
            >
              <h2 className="font-serif text-2xl font-bold text-gray-900 mb-6">
                Upcoming Appointments
              </h2>
              {upcomingBookings.length > 0 ? (
                <div className="space-y-4">
                  {upcomingBookings.map(booking => (
                    <div key={booking.id} className="bg-gray-50 rounded-lg p-4">
                      <div className="flex justify-between items-start mb-2">
                        <div>
                          <h3 className="font-bold text-gray-900">{booking.service}</h3>
                          <p className="text-sm text-gray-600">with {booking.staffName}</p>
                        </div>
                        <span className="badge badge-primary">{booking.status}</span>
                      </div>
                      <div className="flex items-center space-x-4 text-sm text-gray-600">
                        <span>📅 {new Date(booking.date).toLocaleDateString()}</span>
                        <span>🕐 {booking.time}</span>
                        <span>⏱️ {booking.duration} min</span>
                      </div>
                      <div className="mt-3 flex space-x-2">
                        <button className="text-sm text-primary hover:underline">
                          Reschedule
                        </button>
                        <button className="text-sm text-red-600 hover:underline">
                          Cancel
                        </button>
                      </div>
                    </div>
                  ))}
                </div>
              ) : (
                <div className="text-center py-12">
                  <Calendar size={64} className="text-gray-300 mx-auto mb-4" />
                  <p className="text-gray-600 mb-4">No upcoming appointments</p>
                  <button
                    onClick={() => navigate('/booking')}
                    className="btn-primary"
                  >
                    Book Now
                  </button>
                </div>
              )}
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
                Account Details
              </h3>
              <div className="space-y-3 text-sm">
                <div>
                  <p className="text-gray-600">Email</p>
                  <p className="font-medium text-gray-900">{currentUser.email}</p>
                </div>
                <div>
                  <p className="text-gray-600">Phone</p>
                  <p className="font-medium text-gray-900">{currentUser.phone}</p>
                </div>
                <div>
                  <p className="text-gray-600">Member Since</p>
                  <p className="font-medium text-gray-900">
                    {new Date(currentUser.joinDate).toLocaleDateString()}
                  </p>
                </div>
                <div>
                  <p className="text-gray-600">Membership</p>
                  <p className="font-medium text-gray-900">
                    {currentUser.subscription || 'No active membership'}
                  </p>
                </div>
              </div>
              <button className="w-full btn-outline mt-4">
                Edit Profile
              </button>
            </motion.div>

            <motion.div
              initial={{ opacity: 0, y: 20 }}
              animate={{ opacity: 1, y: 0 }}
              transition={{ delay: 0.6 }}
              className="glass-card p-6"
            >
              <h3 className="font-serif text-xl font-bold text-gray-900 mb-4 flex items-center space-x-2">
                <Bell size={20} className="text-primary" />
                <span>Quick Actions</span>
              </h3>
              <div className="space-y-2">
                <button
                  onClick={() => navigate('/booking')}
                  className="w-full text-left px-4 py-3 bg-gray-50 hover:bg-gray-100 rounded-lg transition-colors"
                >
                  📅 Book New Appointment
                </button>
                <button
                  onClick={() => navigate('/subscriptions')}
                  className="w-full text-left px-4 py-3 bg-gray-50 hover:bg-gray-100 rounded-lg transition-colors"
                >
                  💳 View Membership Plans
                </button>
                <button
                  onClick={() => navigate('/shop')}
                  className="w-full text-left px-4 py-3 bg-gray-50 hover:bg-gray-100 rounded-lg transition-colors"
                >
                  🛍️ Shop Products
                </button>
              </div>
            </motion.div>
          </div>
        </div>
      </section>
    </div>
  )
}

export default ClientDashboard