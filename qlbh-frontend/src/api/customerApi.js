// src/api/customerApi.js
import axiosInstance from "./axiosInstance"

const API = "/api/customers"

export const getCustomers = () => axiosInstance.get(API)

export const getCustomer = (id) => axiosInstance.get(`${API}/${id}`)

export const createCustomer = (data) => axiosInstance.post(API, data)

export const updateCustomer = (id, data) => axiosInstance.put(`${API}/${id}`, data)

export const deleteCustomer = (id) => axiosInstance.delete(`${API}/${id}`)