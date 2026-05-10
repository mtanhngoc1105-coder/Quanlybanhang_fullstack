import axios from "axios"

const API = "http://127.0.0.1:8000/api/customers"

export const getCustomers = (search = "", page = 1) => {
  return axios.get(`${API}?search=${search}&page=${page}`)
}

export const getCustomer = (id) => {
  return axios.get(`${API}/${id}`)
}

export const createCustomer = (data) => {
  return axios.post(API, data)
}

export const updateCustomer = (id, data) => {
  return axios.put(`${API}/${id}`, data)
}

export const deleteCustomer = (id) => {
  return axios.delete(`${API}/${id}`)
}
