import { useState } from 'react'
import { motion } from 'framer-motion'
import { Search, UserPlus, Mail, Phone, Star, Calendar, Edit, Trash2 } from 'lucide-react'
import { useApp } from '../context/AppContext'

const AdminStaff = () => {
  const { staffData, deleteStaff } = useApp()
  const [searchQuery, setSearchQuery] = useState('')

  const filteredStaff = staffData.filter(staff =>
    staff.name.toLowerCase().includes(searchQuery.toLowerCase()) ||
    staff.role.toLowerCase().includes(searchQuery.toLowerCase())
  )

  const handleDelete = (id, name) => {
    if (confirm(`Are you sure you want to remove ${name} from staff?`)) {
      deleteStaff(id)
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
            <h1 className="font-serif text-4xl font-bold mb-2">Staff Management</h1>
            <p className="text-xl">Manage your team and their schedules</p>
          </motion.div>
        </div>
      </section>

      <section className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div className="glass-card p-6 mb-6">
          <div className="flex flex-col md:flex-row gap-4">
            <div className="relative flex-1">
              <Search className="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400" size={20} />
              <input
                type="text"
                placeholder="Search staff by name or role..."
                value={searchQuery}
                onChange={(e) => setSearchQuery(e.target.value)}
                className="input-field pl-10 w-full"
              />
            </div>
            <button className="btn-primary flex items-center space-x-2">
              <UserPlus size={20} />
              <span>Add Staff Member</span>
            </button>
          </div>
          <div className="mt-4 text-sm text-gray-600">
            Showing {filteredStaff.length} of {staffData.length} staff members
          </div>
        </div>

        <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
          {filteredStaff.map((staff, index) => (
            <motion.div
              key={staff.id}
              initial={{ opacity: 0, y: 20 }}
              animate={{ opacity: 1, y: 0 }}
              transition={{ delay: index * 0.05 }}
              className="glass-card p-6"
            >
              <div className="flex items-start space-x-4 mb-4">
                <img
                  src={staff.image}
                  alt={staff.name}
                  className="w-20 h-20 rounded-full object-cover"
                />
                <div className="flex-1">
                  <div className="flex justify-between items-start mb-2">
                    <div>
                      <h3 className="font-serif text-xl font-bold text-gray-900">
                        {staff.name}
                      </h3>
                      <p className="text-sm text-gray-600">{staff.role}</p>
                    </div>
                    <div className="flex space-x-2">
                      <button className="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                        <Edit size={18} className="text-gray-600" />
                      </button>
                      <button
                        onClick={() => handleDelete(staff.id, staff.name)}
                        className="p-2 hover:bg-red-50 rounded-lg transition-colors"
                      >
                        <Trash2 size={18} className="text-red-600" />
                      </button>
                    </div>
                  </div>
                  <div className="flex items-center space-x-2">
                    <Star size={16} className="text-yellow-500" fill="currentColor" />
                    <span className="text-sm font-bold text-gray-900">{staff.rating}</span>
                    <span className="text-xs text-gray-500">({staff.completedServices} services)</span>
                  </div>
                </div>
              </div>

              <div className="space-y-2 mb-4">
                <div className="flex items-center space-x-2 text-sm text-gray-600">
                  <Mail size={16} />
                  <span>{staff.email}</span>
                </div>
                <div className="flex items-center space-x-2 text-sm text-gray-600">
                  <Phone size={16} />
                  <span>{staff.phone}</span>
                </div>
                <div className="flex items-center space-x-2 text-sm text-gray-600">
                  <Calendar size={16} />
                  <span>Joined {new Date(staff.joinDate).toLocaleDateString()}</span>
                </div>
              </div>

              <div className="mb-4">
                <p className="text-xs text-gray-600 mb-2">Specialties:</p>
                <div className="flex flex-wrap gap-2">
                  {staff.specialties.map((specialty, i) => (
                    <span key={i} className="badge badge-primary">
                      {specialty}
                    </span>
                  ))}
                </div>
              </div>

              <div>
                <p className="text-xs text-gray-600 mb-2">Availability:</p>
                <div className="flex flex-wrap gap-2">
                  {staff.availability.map((day, i) => (
                    <span key={i} className="badge bg-green-100 text-green-800">
                      {day}
                    </span>
                  ))}
                </div>
              </div>
            </motion.div>
          ))}
        </div>
      </section>
    </div>
  )
}

export default AdminStaff