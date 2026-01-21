import { useState } from 'react'
import { motion } from 'framer-motion'
import { Search, Package, AlertTriangle, Plus, Edit, TrendingDown } from 'lucide-react'
import { useApp } from '../context/AppContext'

const AdminInventory = () => {
  const { inventoryData, updateInventory } = useApp()
  const [searchQuery, setSearchQuery] = useState('')
  const [categoryFilter, setCategoryFilter] = useState('All')
  const [statusFilter, setStatusFilter] = useState('all')

  const categories = ['All', ...new Set(inventoryData.map(i => i.category))]

  const filteredInventory = inventoryData.filter(item => {
    const matchesSearch = item.name.toLowerCase().includes(searchQuery.toLowerCase())
    const matchesCategory = categoryFilter === 'All' || item.category === categoryFilter
    const matchesStatus = 
      statusFilter === 'all' ||
      (statusFilter === 'low' && item.status === 'low-stock') ||
      (statusFilter === 'critical' && item.status === 'critical') ||
      (statusFilter === 'in-stock' && item.status === 'in-stock')
    return matchesSearch && matchesCategory && matchesStatus
  })

  const lowStockCount = inventoryData.filter(i => i.status === 'low-stock' || i.status === 'critical').length

  return (
    <div className="min-h-screen bg-gradient-to-b from-white to-gray-50">
      <section className="gradient-wellness py-16">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <motion.div
            initial={{ opacity: 0, y: 20 }}
            animate={{ opacity: 1, y: 0 }}
            className="text-white"
          >
            <h1 className="font-serif text-4xl font-bold mb-2">Inventory Management</h1>
            <p className="text-xl">Track and manage your wellness products and supplies</p>
          </motion.div>
        </div>
      </section>

      <section className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        {lowStockCount > 0 && (
          <motion.div
            initial={{ opacity: 0, y: 20 }}
            animate={{ opacity: 1, y: 0 }}
            className="glass-card p-6 mb-6 border-l-4 border-yellow-500"
          >
            <div className="flex items-center space-x-3">
              <AlertTriangle size={24} className="text-yellow-600" />
              <div>
                <h3 className="font-bold text-gray-900">Low Stock Alert</h3>
                <p className="text-sm text-gray-600">
                  {lowStockCount} item{lowStockCount > 1 ? 's' : ''} need restocking
                </p>
              </div>
            </div>
          </motion.div>
        )}

        <div className="glass-card p-6 mb-6">
          <div className="flex flex-col lg:flex-row gap-4 mb-4">
            <div className="relative flex-1">
              <Search className="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400" size={20} />
              <input
                type="text"
                placeholder="Search inventory..."
                value={searchQuery}
                onChange={(e) => setSearchQuery(e.target.value)}
                className="input-field pl-10 w-full"
              />
            </div>
            <select
              value={statusFilter}
              onChange={(e) => setStatusFilter(e.target.value)}
              className="input-field lg:w-48"
            >
              <option value="all">All Status</option>
              <option value="in-stock">In Stock</option>
              <option value="low">Low Stock</option>
              <option value="critical">Critical</option>
            </select>
            <button className="btn-primary flex items-center space-x-2">
              <Plus size={20} />
              <span>Add Item</span>
            </button>
          </div>

          <div className="flex flex-wrap gap-3">
            {categories.map(category => (
              <button
                key={category}
                onClick={() => setCategoryFilter(category)}
                className={`px-6 py-2 rounded-full font-medium transition-all duration-300 ${
                  categoryFilter === category
                    ? 'bg-primary text-white shadow-lg scale-105'
                    : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200'
                }`}
              >
                {category}
              </button>
            ))}
          </div>
        </div>

        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          {filteredInventory.map((item, index) => (
            <motion.div
              key={item.id}
              initial={{ opacity: 0, y: 20 }}
              animate={{ opacity: 1, y: 0 }}
              transition={{ delay: index * 0.05 }}
              className="glass-card p-6"
            >
              <div className="flex justify-between items-start mb-4">
                <div>
                  <h3 className="font-serif text-xl font-bold text-gray-900 mb-1">
                    {item.name}
                  </h3>
                  <span className="badge badge-primary">{item.category}</span>
                </div>
                <span className={`badge ${
                  item.status === 'in-stock' ? 'badge-success' :
                  item.status === 'low-stock' ? 'badge-warning' :
                  'badge-error'
                }`}>
                  {item.status === 'in-stock' ? 'In Stock' :
                   item.status === 'low-stock' ? 'Low Stock' :
                   'Critical'}
                </span>
              </div>

              <div className="space-y-3 mb-4">
                <div className="flex justify-between items-center">
                  <span className="text-sm text-gray-600">Current Stock</span>
                  <span className={`text-2xl font-bold ${
                    item.quantity <= item.minQuantity ? 'text-red-600' : 'text-gray-900'
                  }`}>
                    {item.quantity} {item.unit}
                  </span>
                </div>
                <div className="w-full bg-gray-200 rounded-full h-2">
                  <div
                    className={`h-2 rounded-full transition-all ${
                      item.quantity <= item.minQuantity * 0.5 ? 'bg-red-500' :
                      item.quantity <= item.minQuantity ? 'bg-yellow-500' :
                      'bg-green-500'
                    }`}
                    style={{ width: `${Math.min((item.quantity / (item.minQuantity * 2)) * 100, 100)}%` }}
                  />
                </div>
                <div className="flex justify-between text-xs text-gray-500">
                  <span>Min: {item.minQuantity}</span>
                  <span>Target: {item.minQuantity * 2}</span>
                </div>
              </div>

              <div className="space-y-2 mb-4 text-sm">
                <div className="flex justify-between">
                  <span className="text-gray-600">Unit Price</span>
                  <span className="font-medium text-gray-900">${item.price}</span>
                </div>
                <div className="flex justify-between">
                  <span className="text-gray-600">Supplier</span>
                  <span className="font-medium text-gray-900">{item.supplier}</span>
                </div>
                <div className="flex justify-between">
                  <span className="text-gray-600">Last Restocked</span>
                  <span className="font-medium text-gray-900">
                    {new Date(item.lastRestocked).toLocaleDateString()}
                  </span>
                </div>
              </div>

              <div className="flex space-x-2">
                <button className="flex-1 px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary-dark transition-colors text-sm font-medium">
                  Restock
                </button>
                <button className="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                  <Edit size={16} className="text-gray-600" />
                </button>
              </div>
            </motion.div>
          ))}
        </div>
      </section>
    </div>
  )
}

export default AdminInventory