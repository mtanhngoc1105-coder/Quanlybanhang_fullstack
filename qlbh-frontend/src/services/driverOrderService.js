import axiosInstance from "../api/axiosInstance"

const API = "/driver-orders"

export const getDriverOrders = () => axiosInstance.get(API)

export const getDriverOrder = (orderId) => axiosInstance.get(`${API}/${orderId}`)

export const createDriverOrder = (data) => axiosInstance.post(API, data)

export const updateDriverOrder = (orderId, data) => axiosInstance.put(`${API}/${orderId}`, data)

export const deleteDriverOrder = (orderId) => axiosInstance.delete(`${API}/${orderId}`)