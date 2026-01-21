import { motion } from 'framer-motion'
import { Link } from 'react-router-dom'
import { Sparkles, Users, Award, Clock } from 'lucide-react'
import ServiceCard from '../components/ServiceCard'
import { useApp } from '../context/AppContext'
import { useState } from 'react'
import BookingModal from '../components/BookingModal'

const Home = () => {
  const { servicesData } = useApp()
  const [selectedService, setSelectedService] = useState(null)
  const [isModalOpen, setIsModalOpen] = useState(false)

  const featuredServices = servicesData.slice(0, 6)

  const features = [
    {
      icon: Sparkles,
      title: 'Premium Services',
      description: 'Experience luxury wellness treatments with traditional techniques'
    },
    {
      icon: Users,
      title: 'Expert Staff',
      description: 'Certified professionals dedicated to your wellbeing'
    },
    {
      icon: Award,
      title: 'Quality Products',
      description: 'Only the finest organic and natural products'
    },
    {
      icon: Clock,
      title: 'Flexible Hours',
      description: 'Open 7 days a week to fit your schedule'
    }
  ]

  const handleBookService = (service) => {
    setSelectedService(service)
    setIsModalOpen(true)
  }

  return (
    <div className="min-h-screen">
      <section className="relative h-[600px] flex items-center justify-center overflow-hidden">
        <div className="absolute inset-0 gradient-wellness opacity-90" />
        <div 
          className="absolute inset-0 bg-cover bg-center opacity-20"
          style={{ backgroundImage: 'url(https://images.unsplash.com/photo-1540555700478-4be289fbecef?w=1920)' }}
        />
        <motion.div
          initial={{ opacity: 0, y: 30 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.8 }}
          className="relative z-10 text-center text-white px-4 max-w-4xl"
        >
          <h1 className="font-serif text-5xl md:text-6xl font-bold mb-6 text-shadow-lg">
            Welcome to Bogos Land
          </h1>
          <p className="text-xl md:text-2xl mb-8 text-shadow">
            Your Sanctuary for Wellness, Beauty & Relaxation
          </p>
          <div className="flex flex-col sm:flex-row gap-4 justify-center">
            <Link to="/booking" className="btn-primary text-lg px-8 py-4">
              Book Appointment
            </Link>
            <Link to="/services" className="btn-outline bg-white/20 backdrop-blur-sm border-white text-white hover:bg-white hover:text-primary text-lg px-8 py-4">
              Explore Services
            </Link>
          </div>
        </motion.div>
      </section>

      <section className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <motion.div
          initial={{ opacity: 0, y: 20 }}
          whileInView={{ opacity: 1, y: 0 }}
          viewport={{ once: true }}
          className="text-center mb-12"
        >
          <h2 className="font-serif text-4xl font-bold text-gray-900 mb-4">
            Why Choose Bogos Land?
          </h2>
          <p className="text-gray-600 max-w-2xl mx-auto">
            Experience the perfect blend of traditional wellness practices and modern luxury
          </p>
        </motion.div>

        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-16">
          {features.map((feature, index) => (
            <motion.div
              key={index}
              initial={{ opacity: 0, y: 20 }}
              whileInView={{ opacity: 1, y: 0 }}
              viewport={{ once: true }}
              transition={{ delay: index * 0.1 }}
              className="glass-card p-6 text-center"
            >
              <div className="w-16 h-16 gradient-wellness rounded-full flex items-center justify-center mx-auto mb-4">
                <feature.icon size={28} className="text-white" />
              </div>
              <h3 className="font-serif text-xl font-bold text-gray-900 mb-2">
                {feature.title}
              </h3>
              <p className="text-gray-600 text-sm">
                {feature.description}
              </p>
            </motion.div>
          ))}
        </div>
      </section>

      <section className="bg-gradient-to-b from-white to-gray-50 py-16">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <motion.div
            initial={{ opacity: 0, y: 20 }}
            whileInView={{ opacity: 1, y: 0 }}
            viewport={{ once: true }}
            className="text-center mb-12"
          >
            <h2 className="font-serif text-4xl font-bold text-gray-900 mb-4">
              Featured Services
            </h2>
            <p className="text-gray-600 max-w-2xl mx-auto">
              Discover our most popular wellness and beauty treatments
            </p>
          </motion.div>

          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            {featuredServices.map((service, index) => (
              <motion.div
                key={service.id}
                initial={{ opacity: 0, y: 20 }}
                whileInView={{ opacity: 1, y: 0 }}
                viewport={{ once: true }}
                transition={{ delay: index * 0.1 }}
              >
                <ServiceCard 
                  service={service} 
                  onBook={handleBookService}
                />
              </motion.div>
            ))}
          </div>

          <div className="text-center mt-12">
            <Link to="/services" className="btn-primary text-lg px-8 py-4">
              View All Services
            </Link>
          </div>
        </div>
      </section>

      <section className="gradient-wellness py-16">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <motion.div
            initial={{ opacity: 0, y: 20 }}
            whileInView={{ opacity: 1, y: 0 }}
            viewport={{ once: true }}
            className="text-center text-white"
          >
            <h2 className="font-serif text-4xl font-bold mb-6">
              Ready to Begin Your Wellness Journey?
            </h2>
            <p className="text-xl mb-8 max-w-2xl mx-auto">
              Join our community and experience the transformative power of holistic wellness
            </p>
            <div className="flex flex-col sm:flex-row gap-4 justify-center">
              <Link to="/subscriptions" className="btn-accent text-lg px-8 py-4">
                View Membership Plans
              </Link>
              <Link to="/booking" className="bg-white text-primary hover:bg-gray-100 px-8 py-4 rounded-lg font-medium text-lg transition-all duration-300">
                Book Your First Session
              </Link>
            </div>
          </motion.div>
        </div>
      </section>

      <BookingModal
        isOpen={isModalOpen}
        onClose={() => setIsModalOpen(false)}
        service={selectedService}
      />
    </div>
  )
}

export default Home