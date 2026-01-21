import { motion } from 'framer-motion'
import { Check, Star } from 'lucide-react'
import { useApp } from '../context/AppContext'

const Subscriptions = () => {
  const { subscriptionsData, currentUser } = useApp()

  const handleSubscribe = (plan) => {
    if (!currentUser) {
      alert('Please sign in to subscribe to a membership plan')
      return
    }
    alert(`Subscription to ${plan.name} plan initiated! (Demo mode)`)
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
            <h1 className="font-serif text-5xl font-bold mb-4">Membership Plans</h1>
            <p className="text-xl max-w-2xl mx-auto">
              Choose the perfect plan for your wellness journey and enjoy exclusive benefits
            </p>
          </motion.div>
        </div>
      </section>

      <section className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
          {subscriptionsData.map((plan, index) => (
            <motion.div
              key={plan.id}
              initial={{ opacity: 0, y: 20 }}
              animate={{ opacity: 1, y: 0 }}
              transition={{ delay: index * 0.1 }}
              className={`glass-card p-8 relative ${
                plan.popular ? 'ring-4 ring-primary scale-105' : ''
              }`}
            >
              {plan.popular && (
                <div className="absolute -top-4 left-1/2 transform -translate-x-1/2">
                  <div className="bg-primary text-white px-4 py-1 rounded-full text-sm font-bold flex items-center space-x-1">
                    <Star size={14} fill="currentColor" />
                    <span>Most Popular</span>
                  </div>
                </div>
              )}

              <div className="text-center mb-6">
                <h3 className="font-serif text-2xl font-bold text-gray-900 mb-2">
                  {plan.name}
                </h3>
                <div className="flex items-baseline justify-center space-x-2">
                  <span className="text-5xl font-bold text-primary">${plan.price}</span>
                  <span className="text-gray-600">/{plan.duration}</span>
                </div>
              </div>

              <ul className="space-y-4 mb-8">
                {plan.benefits.map((benefit, i) => (
                  <li key={i} className="flex items-start space-x-3">
                    <div className="flex-shrink-0 w-5 h-5 rounded-full bg-green-100 flex items-center justify-center mt-0.5">
                      <Check size={14} className="text-green-600" />
                    </div>
                    <span className="text-gray-700">{benefit}</span>
                  </li>
                ))}
              </ul>

              <button
                onClick={() => handleSubscribe(plan)}
                className={`w-full py-3 rounded-lg font-medium transition-all duration-300 ${
                  plan.popular
                    ? 'btn-primary'
                    : 'bg-white border-2 border-primary text-primary hover:bg-primary hover:text-white'
                }`}
              >
                Choose {plan.name}
              </button>
            </motion.div>
          ))}
        </div>

        <motion.div
          initial={{ opacity: 0, y: 20 }}
          whileInView={{ opacity: 1, y: 0 }}
          viewport={{ once: true }}
          className="mt-16 glass-card p-8"
        >
          <h2 className="font-serif text-3xl font-bold text-gray-900 mb-6 text-center">
            Why Choose a Membership?
          </h2>
          <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div className="text-center">
              <div className="w-16 h-16 gradient-primary rounded-full flex items-center justify-center mx-auto mb-4">
                <span className="text-white text-2xl font-bold">💰</span>
              </div>
              <h3 className="font-serif text-xl font-bold text-gray-900 mb-2">
                Save Money
              </h3>
              <p className="text-gray-600">
                Enjoy significant discounts on all services and products
              </p>
            </div>
            <div className="text-center">
              <div className="w-16 h-16 gradient-secondary rounded-full flex items-center justify-center mx-auto mb-4">
                <span className="text-white text-2xl font-bold">⭐</span>
              </div>
              <h3 className="font-serif text-xl font-bold text-gray-900 mb-2">
                Priority Access
              </h3>
              <p className="text-gray-600">
                Book your preferred time slots before non-members
              </p>
            </div>
            <div className="text-center">
              <div className="w-16 h-16 gradient-accent rounded-full flex items-center justify-center mx-auto mb-4">
                <span className="text-white text-2xl font-bold">🎁</span>
              </div>
              <h3 className="font-serif text-xl font-bold text-gray-900 mb-2">
                Exclusive Perks
              </h3>
              <p className="text-gray-600">
                Access member-only events and special birthday packages
              </p>
            </div>
          </div>
        </motion.div>

        <motion.div
          initial={{ opacity: 0, y: 20 }}
          whileInView={{ opacity: 1, y: 0 }}
          viewport={{ once: true }}
          className="mt-12 text-center"
        >
          <p className="text-gray-600 mb-4">
            Not sure which plan is right for you?
          </p>
          <button className="btn-outline">
            Contact Us for Guidance
          </button>
        </motion.div>
      </section>
    </div>
  )
}

export default Subscriptions