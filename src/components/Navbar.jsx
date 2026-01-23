import { useState } from 'react'
import { Link, useLocation, useNavigate } from 'react-router-dom'
import { motion, AnimatePresence } from 'framer-motion'
import { Menu, X, User, LogOut } from 'lucide-react'
import { useApp } from '../context/AppContext'

const Navbar = () => {
  const [isOpen, setIsOpen] = useState(false)
  const location = useLocation()
  const navigate = useNavigate()
  const { currentUser, isAdmin, logout } = useApp()

  const clientLinks = [
    { path: '/', label: 'Accueil' },
    { path: '/services', label: 'Services' },
    { path: '/subscriptions', label: 'Packs' },
    { path: '/booking', label: 'Réserver' },
    { path: '/subscriptions', label: 'Abonnements' },
    { path: '/shop', label: 'Boutique' }
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

  const handleLogout = () => {
    logout()
    navigate('/')
  }

  return (
    <nav className="bg-white/90 backdrop-blur sticky top-0 z-50 border-b border-gray-100 shadow-sm">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="flex justify-between items-center h-16">
          <Link to="/" className="flex items-center space-x-3">
            <div className="w-10 h-10 bg-gray-900 rounded-full flex items-center justify-center">
              <span className="text-white font-bold text-xl">B</span>
            </div>
            <span className="font-serif text-2xl font-bold text-gray-900">Bogos Land</span>
          </Link>

          <div className="hidden md:flex items-center space-x-6 text-sm">
            {links.map(link => (
              <Link
                key={`${link.path}-${link.label}`}
                to={link.path}
                className={`font-medium transition-colors duration-300 ${
                  location.pathname === link.path
                    ? 'text-gray-900 border-b-2 border-gray-900'
                    : 'text-gray-500 hover:text-gray-900'
                }`}
              >
                {link.label}
              </Link>
            ))}
          </div>

          <div className="hidden md:flex items-center space-x-3">
            <button className="px-3 py-1 rounded-full text-xs font-semibold border border-gray-200 text-gray-700 hover:border-gray-400">
              FR
            </button>
            {currentUser ? (
              <div className="flex items-center space-x-3">
                <Link
                  to={isAdmin ? '/admin' : '/client-dashboard'}
                  className="flex items-center space-x-2 px-4 py-2 rounded-full bg-gray-100 hover:bg-gray-200 transition-colors"
                >
                  <User size={16} />
                  <span className="text-sm font-medium">{currentUser.name}</span>
                </Link>
                <button
                  onClick={handleLogout}
                  className="p-2 text-gray-600 hover:text-gray-900 transition-colors"
                  title="Logout"
                >
                  <LogOut size={18} />
                </button>
              </div>
            ) : (
              <Link to="/client-dashboard" className="bg-gray-900 text-white px-5 py-2 rounded-full text-sm font-semibold hover:bg-gray-800">
                Se connecter
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
                  key={`${link.path}-${link.label}-mobile`}
                  to={link.path}
                  onClick={() => setIsOpen(false)}
                  className={`block px-4 py-2 rounded-lg transition-colors ${
                    location.pathname === link.path
                      ? 'bg-gray-900 text-white'
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
                    Mon compte
                  </Link>
                  <button
                    onClick={() => {
                      handleLogout()
                      setIsOpen(false)
                    }}
                    className="w-full text-left px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-100"
                  >
                    Se déconnecter
                  </button>
                </>
              ) : (
                <Link
                  to="/client-dashboard"
                  onClick={() => setIsOpen(false)}
                  className="block px-4 py-2 rounded-lg bg-gray-900 text-white text-center"
                >
                  Se connecter
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
