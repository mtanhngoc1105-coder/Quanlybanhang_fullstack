import axiosInstance from "../api/axiosInstance"

const API = "/order-items"

export const getOrderItems = () => axiosInstance.get(API)
export const getOrderItem = (id) => axiosInstance.get(`${API}/${id}`)
export const createOrderItem = (data) => axiosInstance.post(API, data)
export const updateOrderItem = (id,data) => axiosInstance.put(`${API}/${id}`, data)
export const deleteOrderItem = (id) => axiosInstance.delete(`${API}/${id}`)