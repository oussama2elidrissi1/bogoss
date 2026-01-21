import { motion } from 'framer-motion'
import { Clock, DollarSign } from 'lucide-react'

const ServiceCard = ({ service, onBook }) => {
  return (
    <motion.div
      whileHover={{ y: -8, scale: 1.02 }}
      className="glass-card overflow-hidden cursor-pointer"
    >
      <div className="relative h-48 overflow-hidden">
        <img
          src={service.image}
          alt={service.name}
          className="w-full h-full object-cover transition-transform duration-500 hover:scale-110"
        />
        <div className="absolute top-3 right-3">
          <span className="badge badge-primary">{service.category}</span>
        </div>
      </div>
      
      <div className="p-6">
        <h3 className="font-serif text-xl font-bold text-gray-900 mb-2">
          {service.name}
        </h3>
        <p className="text-gray-600 text-sm mb-4 line-clamp-2">
          {service.description}
        </p>
        
        <div className="flex items-center justify-between mb-4">
          <div className="flex items-center space-x-2 text-gray-700">
            <Clock size={16} />
            <span className="text-sm">{service.duration} min</span>
          </div>
          <div className="flex items-center space-x-1 text-primary font-bold">
            <DollarSign size={18} />
            <span className="text-lg">{service.price}</span>
          </div>
        </div>
        
        <button
          onClick={() => onBook(service)}
          className="w-full btn-primary"
          disabled={!service.available}
        >
          {service.available ? 'Book Now' : 'Unavailable'}
        </button>
      </div>
    </motion.div>
  )
}

export default ServiceCard