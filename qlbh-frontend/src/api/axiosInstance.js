import axios from 'axios'

const axiosInstance = axios.create({
  baseURL: 'http://127.0.0.1:8000',
  headers: {
    'Content-Type': 'application/json',
    Accept: 'application/json'
  }
})

// Request
axiosInstance.interceptors.request.use((config) => {
  const token = localStorage.getItem('auth_token')

  if (token && token !== 'null') {
    config.headers.Authorization = `Bearer ${token}`
  }

  return config
})

// Response
axiosInstance.interceptors.response.use(
  (res) => res,
  (err) => {
    const status = err.response?.status

    if (status === 401) {
      localStorage.removeItem('auth_token')
      window.location.href = '/login'
    }

    return Promise.reject(err)
  }
)

export default axiosInstance