import { motion } from 'framer-motion'
import { Link } from 'react-router-dom'
import { Star, Sparkles, ShieldCheck, Award, CheckCircle2 } from 'lucide-react'
import { useApp } from '../context/AppContext'

const Home = () => {
  const { servicesData } = useApp()

  const heroImage =
    'https://images.unsplash.com/photo-1515377905703-c4788e51af15?auto=format&fit=crop&w=2000&q=80'
  const servicesBackground =
    'https://images.unsplash.com/photo-1507652313519-d4e9174996dd?auto=format&fit=crop&w=2000&q=80'
  const trustBackground =
    'https://images.unsplash.com/photo-1506354666786-959d6d497f1a?auto=format&fit=crop&w=2000&q=80'

  const features = [
    {
      icon: Star,
      title: '+3500 clients satisfaits',
      description: 'Une clientèle masculine conquise et fidèle.'
    },
    {
      icon: Sparkles,
      title: 'Expertise et soins premium',
      description: 'Barbiers et masseurs professionnels et expérimentés.'
    },
    {
      icon: ShieldCheck,
      title: 'Hygiène & discrétion',
      description: 'Un cadre propre, chic et confidentiel.'
    },
    {
      icon: Award,
      title: 'Résultats visibles',
      description: 'Des soins efficaces dès la première séance.'
    }
  ]

  const services = servicesData.length
    ? servicesData.slice(0, 3).map(service => ({
        title: service.name,
        description: service.description,
        image: service.image
      }))
    : [
        {
          title: 'Hammam & Sauna',
          description: 'Rituels vapeur, détente profonde et purification.',
          image:
            'https://images.unsplash.com/photo-1507652313519-d4e9174996dd?auto=format&fit=crop&w=1200&q=80'
        },
        {
          title: 'Coupe & Barbering',
          description: 'Tailles précises, barbe sculptée, style élégant.',
          image:
            'https://images.unsplash.com/photo-1517836357463-d25dfeac3438?auto=format&fit=crop&w=1200&q=80'
        },
        {
          title: 'Massage Relaxant',
          description: 'Massage signature pour relâcher les tensions.',
          image:
            'https://images.unsplash.com/photo-1524504388940-b1c1722653e1?auto=format&fit=crop&w=1200&q=80'
        }
      ]

  const testimonials = [
    {
      name: 'Ahmed H.',
      rating: 5,
      comment:
        "L'endroit parfait pour se détendre entre hommes. Hammam incroyable et coupe de cheveux, au top."
    },
    {
      name: 'Imad R.',
      rating: 5,
      comment:
        'Un vrai temple de la relaxation masculine. Pro, propre et service haut de gamme.'
    }
  ]

  return (
    <div className="min-h-screen bg-[#f6f3ef] text-gray-900">
      <section className="relative min-h-[560px] flex items-center overflow-hidden">
        <div className="absolute inset-0 bg-cover bg-center" style={{ backgroundImage: `url(${heroImage})` }} />
        <div className="absolute inset-0 bg-black/55" />
        <motion.div
          initial={{ opacity: 0, y: 30 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.8 }}
          className="relative z-10 max-w-5xl px-6 lg:px-12"
        >
          <p className="text-sm uppercase tracking-[0.4em] text-white/80 mb-4">Bogos Land</p>
          <h1 className="font-serif text-4xl md:text-6xl font-semibold text-white mb-5">
            Bogos Land Homme
          </h1>
          <p className="text-lg md:text-2xl text-white/85 mb-8 max-w-2xl">
            Bien-être, grooming & détente dédiés aux hommes.
          </p>
          <div className="flex flex-col sm:flex-row gap-4">
            <Link
              to="/booking"
              className="bg-[#c89255] text-white px-7 py-3 rounded-xl font-semibold shadow-lg hover:bg-[#b78147]"
            >
              Réserver maintenant
            </Link>
            <Link
              to="/services"
              className="bg-gray-900/80 text-white px-7 py-3 rounded-xl font-semibold hover:bg-gray-900"
            >
              Découvrir les services
            </Link>
          </div>
        </motion.div>
      </section>

      <section className="py-16">
        <div className="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
          <motion.div
            initial={{ opacity: 0, y: 20 }}
            whileInView={{ opacity: 1, y: 0 }}
            viewport={{ once: true }}
            className="text-center mb-12"
          >
            <h2 className="font-serif text-3xl md:text-4xl font-semibold text-gray-900 mb-4">
              Pourquoi choisir Bogos Land ?
            </h2>
            <p className="text-gray-600 max-w-2xl mx-auto">
              L&apos;expérience bien-être dédiée aux hommes à Tanger.
            </p>
          </motion.div>

          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            {features.map((feature, index) => (
              <motion.div
                key={feature.title}
                initial={{ opacity: 0, y: 20 }}
                whileInView={{ opacity: 1, y: 0 }}
                viewport={{ once: true }}
                transition={{ delay: index * 0.1 }}
                className="bg-white rounded-2xl shadow-lg border border-white/60 p-6 text-center"
              >
                <div className="w-14 h-14 bg-[#c89255] rounded-full flex items-center justify-center mx-auto mb-4">
                  <feature.icon size={24} className="text-white" />
                </div>
                <h3 className="font-serif text-lg font-semibold text-gray-900 mb-2">
                  {feature.title}
                </h3>
                <p className="text-gray-600 text-sm">{feature.description}</p>
              </motion.div>
            ))}
          </div>
        </div>
      </section>

      <section className="relative py-16">
        <div
          className="absolute inset-0 bg-cover bg-center"
          style={{ backgroundImage: `url(${servicesBackground})` }}
        />
        <div className="absolute inset-0 bg-gray-900/75" />
        <div className="relative z-10 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
          <motion.div
            initial={{ opacity: 0, y: 20 }}
            whileInView={{ opacity: 1, y: 0 }}
            viewport={{ once: true }}
            className="text-center text-white mb-12"
          >
            <p className="uppercase tracking-[0.3em] text-white/60 text-xs mb-3">Sélection prestige</p>
            <h2 className="font-serif text-3xl md:text-4xl font-semibold mb-2">Nos Services</h2>
            <div className="flex justify-center items-center gap-2 text-[#c89255]">
              {Array.from({ length: 5 }).map((_, index) => (
                <Star key={index} size={16} fill="currentColor" />
              ))}
              <span className="text-white/70 text-xs">Service premium</span>
            </div>
          </motion.div>

          <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
            {services.map(service => (
              <div key={service.title} className="rounded-2xl overflow-hidden bg-white/10 border border-white/10">
                <div
                  className="h-44 bg-cover bg-center"
                  style={{ backgroundImage: `url(${service.image})` }}
                />
                <div className="p-5 text-white">
                  <h3 className="font-serif text-xl font-semibold mb-2">{service.title}</h3>
                  <p className="text-sm text-white/70 mb-4">
                    {service.description || 'Une expérience signée Bogos Land, pensée pour vous.'}
                  </p>
                  <Link
                    to="/services"
                    className="inline-flex items-center gap-2 text-sm font-semibold text-[#c89255] hover:text-white"
                  >
                    Découvrir
                    <CheckCircle2 size={16} />
                  </Link>
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>

      <section className="relative py-16">
        <div
          className="absolute inset-0 bg-cover bg-center"
          style={{ backgroundImage: `url(${trustBackground})` }}
        />
        <div className="absolute inset-0 bg-gray-900/80" />
        <div className="relative z-10 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-white">
          <motion.div
            initial={{ opacity: 0, y: 20 }}
            whileInView={{ opacity: 1, y: 0 }}
            viewport={{ once: true }}
            className="text-center mb-10"
          >
            <h2 className="font-serif text-3xl md:text-4xl font-semibold mb-4">
              Ils nous font confiance
            </h2>
            <div className="flex justify-center items-center gap-2 text-[#c89255]">
              {Array.from({ length: 5 }).map((_, index) => (
                <Star key={index} size={18} fill="currentColor" />
              ))}
              <span className="text-white/70 text-sm">4.9 · 350+ avis</span>
            </div>
          </motion.div>

          <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
            {testimonials.map(testimonial => (
              <div key={testimonial.name} className="bg-white/10 border border-white/10 rounded-2xl p-6">
                <div className="flex items-center gap-3 mb-3">
                  <div className="w-10 h-10 rounded-full bg-[#c89255] flex items-center justify-center text-gray-900 font-semibold">
                    {testimonial.name[0]}
                  </div>
                  <div>
                    <p className="font-semibold">{testimonial.name}</p>
                    <div className="flex items-center gap-1 text-[#c89255]">
                      {Array.from({ length: testimonial.rating }).map((_, index) => (
                        <Star key={index} size={14} fill="currentColor" />
                      ))}
                    </div>
                  </div>
                </div>
                <p className="text-sm text-white/80">{testimonial.comment}</p>
              </div>
            ))}
          </div>
        </div>
      </section>
    </div>
  )
}

export default Home
