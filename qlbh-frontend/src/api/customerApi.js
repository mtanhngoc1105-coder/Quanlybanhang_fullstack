// src/api/customerApi.js
import axios from "axios"

const API = "http://localhost:8000/api/customers"

export const getCustomers = () => axios.get(API)

export const getCustomer = (id) => axios.get(`${API}/${id}`)

export const createCustomer = (data) => axios.post(API, data)

export const updateCustomer = (id, data) => axios.put(`${API}/${id}`, data)

export const deleteCustomer = (id) => axios.delete(`${API}/${id}`)