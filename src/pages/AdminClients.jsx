import { useState } from 'react'
import { motion } from 'framer-motion'
import { Search, UserPlus, Mail, Phone, Calendar, DollarSign, Edit, Trash2 } from 'lucide-react'
import { useApp } from '../context/AppContext'

const AdminClients = () => {
  const { clientsData, deleteClient } = useApp()
  const [searchQuery, setSearchQuery] = useState('')
  const [sortBy, setSortBy] = useState('name')

  const filteredClients = clientsData
    .filter(client => 
      client.name.toLowerCase().includes(searchQuery.toLowerCase()) ||
      client.email.toLowerCase().includes(searchQuery.toLowerCase())
    )
    .sort((a, b) => {
      if (sortBy === 'name') return a.name.localeCompare(b.name)
      if (sortBy === 'visits') return b.visits - a.visits
      if (sortBy === 'spent') return b.totalSpent - a.totalSpent
      return 0
    })

  const handleDelete = (id, name) => {
    if (confirm(`Are you sure you want to delete ${name}?`)) {
      deleteClient(id)
    }
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
            <h1 className="font-serif text-4xl font-bold mb-2">Client Management</h1>
            <p className="text-xl">Manage your client database and relationships</p>
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
                placeholder="Search clients by name or email..."
                value={searchQuery}
                onChange={(e) => setSearchQuery(e.target.value)}
                className="input-field pl-10 w-full"
              />
            </div>
            <select
              value={sortBy}
              onChange={(e) => setSortBy(e.target.value)}
              className="input-field md:w-48"
            >
              <option value="name">Sort by Name</option>
              <option value="visits">Sort by Visits</option>
              <option value="spent">Sort by Spending</option>
            </select>
            <button className="btn-primary flex items-center space-x-2">
              <UserPlus size={20} />
              <span>Add Client</span>
            </button>
          </div>

          <div className="text-sm text-gray-600 mb-4">
            Showing {filteredClients.length} of {clientsData.length} clients
          </div>
        </div>

        <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
          {filteredClients.map((client, index) => (
            <motion.div
              key={client.id}
              initial={{ opacity: 0, y: 20 }}
              animate={{ opacity: 1, y: 0 }}
              transition={{ delay: index * 0.05 }}
              className="glass-card p-6"
            >
              <div className="flex justify-between items-start mb-4">
                <div>
                  <h3 className="font-serif text-xl font-bold text-gray-900 mb-1">
                    {client.name}
                  </h3>
                  {client.subscription && (
                    <span className="badge badge-primary">{client.subscription}</span>
                  )}
                </div>
                <div className="flex space-x-2">
                  <button className="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                    <Edit size={18} className="text-gray-600" />
                  </button>
                  <button
                    onClick={() => handleDelete(client.id, client.name)}
                    className="p-2 hover:bg-red-50 rounded-lg transition-colors"
                  >
                    <Trash2 size={18} className="text-red-600" />
                  </button>
                </div>
              </div>

              <div className="space-y-2 mb-4">
                <div className="flex items-center space-x-2 text-sm text-gray-600">
                  <Mail size={16} />
                  <span>{client.email}</span>
                </div>
                <div className="flex items-center space-x-2 text-sm text-gray-600">
                  <Phone size={16} />
                  <span>{client.phone}</span>
                </div>
                <div className="flex items-center space-x-2 text-sm text-gray-600">
                  <Calendar size={16} />
                  <span>Joined {new Date(client.joinDate).toLocaleDateString()}</span>
                </div>
              </div>

              <div className="grid grid-cols-3 gap-4 pt-4 border-t border-gray-200">
                <div className="text-center">
                  <p className="text-2xl font-bold text-primary">{client.visits}</p>
                  <p className="text-xs text-gray-600">Visits</p>
                </div>
                <div className="text-center">
                  <p className="text-2xl font-bold text-secondary">${client.totalSpent}</p>
                  <p className="text-xs text-gray-600">Spent</p>
                </div>
                <div className="text-center">
                  <p className="text-sm font-medium text-gray-700">
                    {client.lastVisit ? new Date(client.lastVisit).toLocaleDateString('en-US', { month: 'short', day: 'numeric' }) : 'N/A'}
                  </p>
                  <p className="text-xs text-gray-600">Last Visit</p>
                </div>
              </div>

              {client.preferences && client.preferences.length > 0 && (
                <div className="mt-4 pt-4 border-t border-gray-200">
                  <p className="text-xs text-gray-600 mb-2">Preferences:</p>
                  <div className="flex flex-wrap gap-2">
                    {client.preferences.map((pref, i) => (
                      <span key={i} className="badge bg-gray-100 text-gray-700">
                        {pref}
                      </span>
                    ))}
                  </div>
                </div>
              )}

              {client.notes && (
                <div className="mt-4 pt-4 border-t border-gray-200">
                  <p className="text-xs text-gray-600 mb-1">Notes:</p>
                  <p className="text-sm text-gray-700">{client.notes}</p>
                </div>
              )}
            </motion.div>
          ))}
        </div>
      </section>
    </div>
  )
}

export default AdminClients