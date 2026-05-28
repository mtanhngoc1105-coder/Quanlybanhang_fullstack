import axiosInstance from "../api/axiosInstance"

const API = "/api/products"

export const getProducts = (params = {}) => {
  const queryParams = new URLSearchParams()
  
  if (params.search) queryParams.append('search', params.search)
  if (params.category_id) queryParams.append('category_id', params.category_id)
  if (params.page) queryParams.append('page', params.page)
  if (params.per_page) queryParams.append('per_page', params.per_page)
  
  const queryString = queryParams.toString()
  return axiosInstance.get(`${API}${queryString ? '?' + queryString : ''}`)
}

export const getProduct = (id) => {
  return axiosInstance.get(`${API}/${id}`)
}

export const createProduct = (data) => {
  return axiosInstance.post(API, data)
}

export const updateProduct = (id, data) => {
  return axiosInstance.put(`${API}/${id}`, data)
}

export const deleteProduct = (id) => {
  return axiosInstance.delete(`${API}/${id}`)
}