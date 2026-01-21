import { useState } from 'react'
import { motion } from 'framer-motion'
import { Search, Plus, Edit, Trash2, Calendar, Tag } from 'lucide-react'
import { useApp } from '../context/AppContext'

const AdminPromotions = () => {
  const { promotionsData, addPromotion, updatePromotion, deletePromotion } = useApp()
  const [searchQuery, setSearchQuery] = useState('')
  const [statusFilter, setStatusFilter] = useState('All')

  const filteredPromotions = promotionsData.filter(promo => {
    const matchesStatus = statusFilter === 'All' || promo.status === statusFilter
    const matchesSearch = promo.title.toLowerCase().includes(searchQuery.toLowerCase()) ||
                         promo.code.toLowerCase().includes(searchQuery.toLowerCase())
    return matchesStatus && matchesSearch
  })

  return (
    <div className="min-h-screen bg-gradient-to-b from-white to-gray-50">
      <section className="gradient-wellness py-16">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <motion.div
            initial={{ opacity: 0, y: 20 }}
            animate={{ opacity: 1, y: 0 }}
            className="text-white"
          >
            <h1 className="font-serif text-4xl font-bold mb-2">Promotion Management</h1>
            <p className="text-xl">Manage discounts and special offers</p>
          </motion.div>
        </div>
      </section>

      <section className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div className="glass-card p-6 mb-6">
          <div className="flex flex-col md:flex-row gap-4 mb-6">
            <div className="relative flex-1">
              <Search className="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400" size={20} />
              <input
                type="text"
                placeholder="Search promotions..."
                value={searchQuery}
                onChange={(e) => setSearchQuery(e.target.value)}
                className="input-field pl-10 w-full"
              />
            </div>
            <button className="btn-primary flex items-center space-x-2">
              <Plus size={20} />
              <span>Add Promotion</span>
            </button>
          </div>

          <div className="flex flex-wrap gap-3">
            {['All', 'active', 'expired', 'inactive'].map(status => (
              <button
                key={status}
                onClick={() => setStatusFilter(status)}
                className={`px-6 py-2 rounded-full font-medium transition-all duration-300 ${
                  statusFilter === status
                    ? 'bg-primary text-white shadow-lg scale-105'
                    : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200'
                }`}
              >
                {status.charAt(0).toUpperCase() + status.slice(1)}
              </button>
            ))}
          </div>
        </div>

        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          {filteredPromotions.map((promo, index) => (
            <motion.div
              key={promo.id}
              initial={{ opacity: 0, y: 20 }}
              animate={{ opacity: 1, y: 0 }}
              transition={{ delay: index * 0.05 }}
              className="glass-card overflow-hidden"
            >
              <div className="p-6">
                <div className="flex justify-between items-start mb-4">
                  <div className="flex items-center space-x-2">
                    <Tag className="text-primary" size={24} />
                    <div>
                      <h3 className="font-serif text-xl font-bold text-gray-900">
                        {promo.title}
                      </h3>
                      <span className={`badge ${
                        promo.status === 'active' ? 'badge-success' : 'badge-error'
                      }`}>
                        {promo.status}
                      </span>
                    </div>
                  </div>
                </div>

                <p className="text-sm text-gray-600 mb-4">
                  {promo.description}
                </p>

                <div className="bg-gray-50 rounded-lg p-4 mb-4 space-y-2">
                  <div className="flex justify-between text-sm">
                    <span className="text-gray-600">Discount</span>
                    <span className="font-bold text-primary">
                      {promo.type === 'percentage' ? `${promo.discount}%` : `$${promo.discount}`}
                    </span>
                  </div>
                  <div className="flex justify-between text-sm">
                    <span className="text-gray-600">Code</span>
                    <span className="font-mono font-medium">{promo.code}</span>
                  </div>
                  <div className="flex items-center space-x-2 text-sm text-gray-600">
                    <Calendar size={14} />
                    <span>
                      {new Date(promo.validFrom).toLocaleDateString()} - {new Date(promo.validUntil).toLocaleDateString()}
                    </span>
                  </div>
                </div>

                <div className="flex space-x-2">
                  <button className="flex-1 px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors flex items-center justify-center space-x-2">
                    <Edit size={16} />
                    <span className="text-sm font-medium">Edit</span>
                  </button>
                  <button 
                    onClick={() => deletePromotion(promo.id)}
                    className="px-4 py-2 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg transition-colors"
                  >
                    <Trash2 size={16} />
                  </button>
                </div>
              </div>
            </motion.div>
          ))}
        </div>
      </section>
    </div>
  )
}

export default AdminPromotions
