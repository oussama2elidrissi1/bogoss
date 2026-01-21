import { Routes, Route } from 'react-router-dom'
import { motion, AnimatePresence } from 'framer-motion'
import Navbar from './components/Navbar'
import Footer from './components/Footer'
import Home from './pages/Home'
import Services from './pages/Services'
import Booking from './pages/Booking'
import Subscriptions from './pages/Subscriptions'
import Shop from './pages/Shop'
import ClientDashboard from './pages/ClientDashboard'
import AdminDashboard from './pages/AdminDashboard'
import AdminClients from './pages/AdminClients'
import AdminServices from './pages/AdminServices'
import AdminBookings from './pages/AdminBookings'
import AdminStaff from './pages/AdminStaff'
import AdminInventory from './pages/AdminInventory'
import AdminProducts from './pages/AdminProducts'
import AdminPromotions from './pages/AdminPromotions'
import AdminAnalytics from './pages/AdminAnalytics'

const App = () => {
  return (
    <div className="min-h-screen flex flex-col">
      <Navbar />
      <main className="flex-1">
        <AnimatePresence mode="wait">
          <Routes>
            <Route path="/" element={<Home />} />
            <Route path="/services" element={<Services />} />
            <Route path="/booking" element={<Booking />} />
            <Route path="/subscriptions" element={<Subscriptions />} />
            <Route path="/shop" element={<Shop />} />
            <Route path="/client-dashboard" element={<ClientDashboard />} />
            <Route path="/admin" element={<AdminDashboard />} />
            <Route path="/admin/clients" element={<AdminClients />} />
            <Route path="/admin/services" element={<AdminServices />} />
            <Route path="/admin/bookings" element={<AdminBookings />} />
            <Route path="/admin/staff" element={<AdminStaff />} />
            <Route path="/admin/inventory" element={<AdminInventory />} />
            <Route path="/admin/products" element={<AdminProducts />} />
            <Route path="/admin/promotions" element={<AdminPromotions />} />
            <Route path="/admin/analytics" element={<AdminAnalytics />} />
          </Routes>
        </AnimatePresence>
      </main>
      <Footer />
    </div>
  )
}

export default App