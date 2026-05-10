import axios from "axios"

const API = "http://127.0.0.1:8000/api/driver-orders"

export const getDriverOrders = () => axios.get(API)

export const getDriverOrder = (orderId) => axios.get(`${API}/${orderId}`)

export const createDriverOrder = (data) => axios.post(API, data)

export const updateDriverOrder = (orderId, data) => axios.put(`${API}/${orderId}`, data)

export const deleteDriverOrder = (orderId) => axios.delete(`${API}/${orderId}`)