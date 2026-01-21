import { useState } from 'react'
import { Link, useLocation, useNavigate } from 'react-router-dom'
import { motion, AnimatePresence } from 'framer-motion'
import { Menu, X, User, ShoppingCart, Bell, LogOut } from 'lucide-react'
import { useApp } from '../context/AppContext'

const Navbar = () => {
  const [isOpen, setIsOpen] = useState(false)
  const location = useLocation()
  const navigate = useNavigate()
  const { currentUser, isAdmin, logout, cart, notifications } = useApp()

  const clientLinks = [
    { path: '/', label: 'Home' },
    { path: '/services', label: 'Services' },
    { path: '/booking', label: 'Book Now' },
    { path: '/subscriptions', label: 'Memberships' },
    { path: '/shop', label: 'Shop' }
  ]

  const adminLinks = [
    { path: '/admin', label: 'Dashboard' },
    { path: '/admin/clients', label: 'Clients' },
    { path: '/admin/bookings', label: 'Bookings' },
    { path: '/admin/services', label: 'Services' },
    { path: '/admin/staff', label: 'Staff' },
    { path: '/admin/inventory', label: 'Inventory' },
    { path: '/admin/products', label: 'Products' },
    { path: '/admin/promotions', label: 'Promotions' },
    { path: '/admin/analytics', label: 'Analytics' }
  ]

  const links = isAdmin ? adminLinks : clientLinks
  const unreadNotifications = notifications.filter(n => !n.read).length
  const cartItemsCount = cart.reduce((sum, item) => sum + item.quantity, 0)

  const handleLogout = () => {
    logout()
    navigate('/')
  }

  return (
    <nav className="glass-card sticky top-0 z-50 shadow-lg">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="flex justify-between items-center h-16">
          <Link to="/" className="flex items-center space-x-3">
            <div className="w-10 h-10 gradient-wellness rounded-full flex items-center justify-center">
              <span className="text-white font-bold text-xl">B</span>
            </div>
            <span className="font-serif text-2xl font-bold text-primary">Bogos Land</span>
          </Link>

          <div className="hidden md:flex items-center space-x-8">
            {links.map(link => (
              <Link
                key={link.path}
                to={link.path}
                className={`text-sm font-medium transition-colors duration-300 ${
                  location.pathname === link.path
                    ? 'text-primary border-b-2 border-primary'
                    : 'text-gray-700 hover:text-primary'
                }`}
              >
                {link.label}
              </Link>
            ))}
          </div>

          <div className="hidden md:flex items-center space-x-4">
            {!isAdmin && (
              <>
                <button
                  onClick={() => navigate('/shop')}
                  className="relative p-2 text-gray-700 hover:text-primary transition-colors"
                >
                  <ShoppingCart size={20} />
                  {cartItemsCount > 0 && (
                    <span className="absolute -top-1 -right-1 bg-accent text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                      {cartItemsCount}
                    </span>
                  )}
                </button>
                <button className="relative p-2 text-gray-700 hover:text-primary transition-colors">
                  <Bell size={20} />
                  {unreadNotifications > 0 && (
                    <span className="absolute -top-1 -right-1 bg-danger text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                      {unreadNotifications}
                    </span>
                  )}
                </button>
              </>
            )}
            {currentUser ? (
              <div className="flex items-center space-x-3">
                <Link
                  to={isAdmin ? '/admin' : '/client-dashboard'}
                  className="flex items-center space-x-2 px-4 py-2 rounded-lg hover:bg-gray-100 transition-colors"
                >
                  <User size={18} />
                  <span className="text-sm font-medium">{currentUser.name}</span>
                </Link>
                <button
                  onClick={handleLogout}
                  className="p-2 text-gray-700 hover:text-danger transition-colors"
                  title="Logout"
                >
                  <LogOut size={20} />
                </button>
              </div>
            ) : (
              <Link to="/client-dashboard" className="btn-primary">
                Sign In
              </Link>
            )}
          </div>

          <button
            onClick={() => setIsOpen(!isOpen)}
            className="md:hidden p-2 text-gray-700"
          >
            {isOpen ? <X size={24} /> : <Menu size={24} />}
          </button>
        </div>
      </div>

      <AnimatePresence>
        {isOpen && (
          <motion.div
            initial={{ opacity: 0, height: 0 }}
            animate={{ opacity: 1, height: 'auto' }}
            exit={{ opacity: 0, height: 0 }}
            className="md:hidden bg-white border-t border-gray-200"
          >
            <div className="px-4 py-4 space-y-3">
              {links.map(link => (
                <Link
                  key={link.path}
                  to={link.path}
                  onClick={() => setIsOpen(false)}
                  className={`block px-4 py-2 rounded-lg transition-colors ${
                    location.pathname === link.path
                      ? 'bg-primary text-white'
                      : 'text-gray-700 hover:bg-gray-100'
                  }`}
                >
                  {link.label}
                </Link>
              ))}
              {currentUser ? (
                <>
                  <Link
                    to={isAdmin ? '/admin' : '/client-dashboard'}
                    onClick={() => setIsOpen(false)}
                    className="block px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-100"
                  >
                    My Account
                  </Link>
                  <button
                    onClick={() => {
                      handleLogout()
                      setIsOpen(false)
                    }}
                    className="w-full text-left px-4 py-2 rounded-lg text-danger hover:bg-red-50"
                  >
                    Logout
                  </button>
                </>
              ) : (
                <Link
                  to="/client-dashboard"
                  onClick={() => setIsOpen(false)}
                  className="block px-4 py-2 rounded-lg bg-primary text-white text-center"
                >
                  Sign In
                </Link>
              )}
            </div>
          </motion.div>
        )}
      </AnimatePresence>
    </nav>
  )
}

export default Navbar