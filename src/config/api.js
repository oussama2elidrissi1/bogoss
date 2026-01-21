const API_BASE_URL = import.meta.env.VITE_API_URL || 'http://localhost:8000/api'

export const api = {
  async request(endpoint, options = {}) {
    const token = localStorage.getItem('auth_token')
    
    const config = {
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        ...(token && { Authorization: `Bearer ${token}` }),
        ...options.headers,
      },
      ...options,
    }

    try {
      const response = await fetch(`${API_BASE_URL}${endpoint}`, config)
      const data = await response.json()

      if (!response.ok) {
        throw new Error(data.message || 'An error occurred')
      }

      return data
    } catch (error) {
      console.error('API Error:', error)
      throw error
    }
  },

  get(endpoint) {
    return this.request(endpoint, { method: 'GET' })
  },

  post(endpoint, data) {
    return this.request(endpoint, {
      method: 'POST',
      body: JSON.stringify(data),
    })
  },

  put(endpoint, data) {
    return this.request(endpoint, {
      method: 'PUT',
      body: JSON.stringify(data),
    })
  },

  delete(endpoint) {
    return this.request(endpoint, { method: 'DELETE' })
  },
}

export default api
