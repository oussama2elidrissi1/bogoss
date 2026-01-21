import { Link } from 'react-router-dom'
import { Facebook, Instagram, Twitter, Mail, Phone, MapPin } from 'lucide-react'

const Footer = () => {
  const currentYear = new Date().getFullYear()

  return (
    <footer className="bg-gray-900 text-gray-300">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div className="grid grid-cols-1 md:grid-cols-4 gap-8">
          <div className="space-y-4">
            <div className="flex items-center space-x-3">
              <div className="w-10 h-10 gradient-wellness rounded-full flex items-center justify-center">
                <span className="text-white font-bold text-xl">B</span>
              </div>
              <span className="font-serif text-2xl font-bold text-white">Bogos Land</span>
            </div>
            <p className="text-sm">
              Your sanctuary for wellness, beauty, and relaxation. Experience traditional treatments with modern luxury.
            </p>
            <div className="flex space-x-4">
              <a href="#" className="hover:text-primary transition-colors">
                <Facebook size={20} />
              </a>
              <a href="#" className="hover:text-primary transition-colors">
                <Instagram size={20} />
              </a>
              <a href="#" className="hover:text-primary transition-colors">
                <Twitter size={20} />
              </a>
            </div>
          </div>

          <div>
            <h3 className="text-white font-semibold mb-4">Quick Links</h3>
            <ul className="space-y-2">
              <li>
                <Link to="/services" className="hover:text-primary transition-colors">
                  Our Services
                </Link>
              </li>
              <li>
                <Link to="/booking" className="hover:text-primary transition-colors">
                  Book Appointment
                </Link>
              </li>
              <li>
                <Link to="/subscriptions" className="hover:text-primary transition-colors">
                  Membership Plans
                </Link>
              </li>
              <li>
                <Link to="/shop" className="hover:text-primary transition-colors">
                  Shop Products
                </Link>
              </li>
            </ul>
          </div>

          <div>
            <h3 className="text-white font-semibold mb-4">Services</h3>
            <ul className="space-y-2 text-sm">
              <li>Hair Salon</li>
              <li>Traditional Hammam</li>
              <li>Hijama Therapy</li>
              <li>Manicure & Pedicure</li>
              <li>Massage Therapy</li>
              <li>Wellness Consultation</li>
            </ul>
          </div>

          <div>
            <h3 className="text-white font-semibold mb-4">Contact Us</h3>
            <ul className="space-y-3 text-sm">
              <li className="flex items-start space-x-2">
                <MapPin size={18} className="mt-1 flex-shrink-0" />
                <span>123 Wellness Avenue, Spa District, City 12345</span>
              </li>
              <li className="flex items-center space-x-2">
                <Phone size={18} />
                <span>+1 (234) 567-8900</span>
              </li>
              <li className="flex items-center space-x-2">
                <Mail size={18} />
                <span>info@bogosland.com</span>
              </li>
            </ul>
            <div className="mt-4">
              <p className="text-sm font-semibold text-white mb-2">Opening Hours</p>
              <p className="text-sm">Mon - Sat: 9:00 AM - 8:00 PM</p>
              <p className="text-sm">Sunday: 10:00 AM - 6:00 PM</p>
            </div>
          </div>
        </div>

        <div className="border-t border-gray-800 mt-8 pt-8 text-center text-sm">
          <p>&copy; {currentYear} Bogos Land Wellness Center. All rights reserved.</p>
          <div className="mt-2 space-x-4">
            <Link to="#" className="hover:text-primary transition-colors">
              Privacy Policy
            </Link>
            <Link to="#" className="hover:text-primary transition-colors">
              Terms of Service
            </Link>
            <Link to="#" className="hover:text-primary transition-colors">
              Cookie Policy
            </Link>
          </div>
        </div>
      </div>
    </footer>
  )
}

export default Footer