import { useState } from 'react'
import { motion } from 'framer-motion'
import Calendar from 'react-calendar'
import 'react-calendar/dist/Calendar.css'
import { Clock, User, Calendar as CalendarIcon } from 'lucide-react'
import { useApp } from '../context/AppContext'
import ServiceCard from '../components/ServiceCard'
import BookingModal from '../components/BookingModal'

const Booking = () => {
  const { servicesData, bookingsData, staffData } = useApp()
  const [selectedDate, setSelectedDate] = useState(new Date())
  const [selectedService, setSelectedService] = useState(null)
  const [isModalOpen, setIsModalOpen] = useState(false)
  const [selectedCategory, setSelectedCategory] = useState('All')

  const categories = ['All', ...new Set(servicesData.map(s => s.category))]

  const filteredServices = selectedCategory === 'All'
    ? servicesData
    : servicesData.filter(s => s.category === selectedCategory)

  const dateBookings = bookingsData.filter(booking => {
    const bookingDate = new Date(booking.date)
    return bookingDate.toDateString() === selectedDate.toDateString()
  })

  const availableStaff = staffData.filter(staff => {
    const dayName = selectedDate.toLocaleDateString('en-US', { weekday: 'long' })
    return staff.availability.includes(dayName)
  })

  const handleBookService = (service) => {
    setSelectedService(service)
    setIsModalOpen(true)
  }

  return (
    <div className="min-h-screen bg-gradient-to-b from-white to-gray-50">
      <section className="gradient-wellness py-16">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <motion.div
            initial={{ opacity: 0, y: 20 }}
            animate={{ opacity: 1, y: 0 }}
            className="text-center text-white"
          >
            <h1 className="font-serif text-5xl font-bold mb-4">Book Your Appointment</h1>
            <p className="text-xl max-w-2xl mx-auto">
              Choose your service and preferred date to get started
            </p>
          </motion.div>
        </div>
      </section>

      <section className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div className="grid grid-cols-1 lg:grid-cols-3 gap-8">
          <div className="lg:col-span-2">
            <div className="mb-8">
              <h2 className="font-serif text-2xl font-bold text-gray-900 mb-4">
                Select a Service
              </h2>
              <div className="flex flex-wrap gap-3 mb-6">
                {categories.map(category => (
                  <button
                    key={category}
                    onClick={() => setSelectedCategory(category)}
                    className={`px-6 py-2 rounded-full font-medium transition-all duration-300 ${
                      selectedCategory === category
                        ? 'bg-primary text-white shadow-lg scale-105'
                        : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200'
                    }`}
                  >
                    {category}
                  </button>
                ))}
              </div>
              <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                {filteredServices.map((service, index) => (
                  <motion.div
                    key={service.id}
                    initial={{ opacity: 0, y: 20 }}
                    animate={{ opacity: 1, y: 0 }}
                    transition={{ delay: index * 0.1 }}
                  >
                    <ServiceCard 
                      service={service} 
                      onBook={handleBookService}
                    />
                  </motion.div>
                ))}
              </div>
            </div>
          </div>

          <div className="space-y-6">
            <div className="glass-card p-6">
              <h2 className="font-serif text-2xl font-bold text-gray-900 mb-4 flex items-center space-x-2">
                <CalendarIcon size={24} className="text-primary" />
                <span>Select Date</span>
              </h2>
              <div className="booking-calendar">
                <Calendar
                  onChange={setSelectedDate}
                  value={selectedDate}
                  minDate={new Date()}
                  className="w-full border-0 rounded-lg"
                />
              </div>
            </div>

            <div className="glass-card p-6">
              <h3 className="font-serif text-xl font-bold text-gray-900 mb-4 flex items-center space-x-2">
                <Clock size={20} className="text-primary" />
                <span>Bookings on {selectedDate.toLocaleDateString()}</span>
              </h3>
              {dateBookings.length > 0 ? (
                <div className="space-y-3">
                  {dateBookings.map(booking => (
                    <div key={booking.id} className="bg-gray-50 rounded-lg p-3">
                      <div className="flex justify-between items-start mb-1">
                        <span className="font-medium text-gray-900">{booking.service}</span>
                        <span className="badge badge-primary">{booking.time}</span>
                      </div>
                      <p className="text-sm text-gray-600">{booking.clientName}</p>
                    </div>
                  ))}
                </div>
              ) : (
                <p className="text-gray-500 text-sm">No bookings for this date</p>
              )}
            </div>

            <div className="glass-card p-6">
              <h3 className="font-serif text-xl font-bold text-gray-900 mb-4 flex items-center space-x-2">
                <User size={20} className="text-primary" />
                <span>Available Staff</span>
              </h3>
              {availableStaff.length > 0 ? (
                <div className="space-y-3">
                  {availableStaff.map(staff => (
                    <div key={staff.id} className="flex items-center space-x-3 bg-gray-50 rounded-lg p-3">
                      <img
                        src={staff.image}
                        alt={staff.name}
                        className="w-12 h-12 rounded-full object-cover"
                      />
                      <div className="flex-1">
                        <p className="font-medium text-gray-900">{staff.name}</p>
                        <p className="text-sm text-gray-600">{staff.role}</p>
                      </div>
                      <div className="text-right">
                        <div className="flex items-center space-x-1">
                          <span className="text-yellow-500">★</span>
                          <span className="text-sm font-medium">{staff.rating}</span>
                        </div>
                      </div>
                    </div>
                  ))}
                </div>
              ) : (
                <p className="text-gray-500 text-sm">No staff available on this day</p>
              )}
            </div>
          </div>
        </div>
      </section>

      <BookingModal
        isOpen={isModalOpen}
        onClose={() => setIsModalOpen(false)}
        service={selectedService}
      />

      <style>{`
        .booking-calendar .react-calendar {
          border: none;
          font-family: inherit;
        }
        .booking-calendar .react-calendar__tile--active {
          background: #4A90A4;
          color: white;
        }
        .booking-calendar .react-calendar__tile--now {
          background: #7FA99B;
          color: white;
        }
        .booking-calendar .react-calendar__tile:hover {
          background: #e8f4f8;
        }
        .booking-calendar .react-calendar__navigation button:hover {
          background: #e8f4f8;
        }
      `}</style>
    </div>
  )
}

export default Booking