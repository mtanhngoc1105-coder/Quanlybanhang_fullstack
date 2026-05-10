import axios from "axios"

const API = "http://127.0.0.1:8000/api/products"

export const getProducts = (params = {}) => {
  const queryParams = new URLSearchParams()
  
  if (params.search) queryParams.append('search', params.search)
  if (params.category_id) queryParams.append('category_id', params.category_id)
  if (params.page) queryParams.append('page', params.page)
  
  const queryString = queryParams.toString()
  return axios.get(`${API}${queryString ? '?' + queryString : ''}`)
}

export const getProduct = (id) => {
  return axios.get(`${API}/${id}`)
}

export const createProduct = (data) => {
  return axios.post(API, data)
}

export const updateProduct = (id, data) => {
  return axios.put(`${API}/${id}`, data)
}

export const deleteProduct = (id) => {
  return axios.delete(`${API}/${id}`)
}