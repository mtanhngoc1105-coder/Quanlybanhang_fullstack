import axiosInstance from "../api/axiosInstance"

const API = "/api/customers"

export const getCustomers = (search = "", page = 1) => {
  return axiosInstance.get(`${API}?search=${search}&page=${page}`)
}

export const getCustomer = (id) => {
  return axiosInstance.get(`${API}/${id}`)
}

export const createCustomer = (data) => {
  return axiosInstance.post(API, data)
}

export const updateCustomer = (id, data) => {
  return axiosInstance.put(`${API}/${id}`, data)
}

export const deleteCustomer = (id) => {
  return axiosInstance.delete(`${API}/${id}`)
}
