import axios from "axios"

const API = "http://127.0.0.1:8000/api/order-items"

export const getOrderItems = () => axios.get(API)
export const getOrderItem = (id) => axios.get(`${API}/${id}`)
export const createOrderItem = (data) => axios.post(API, data)
export const updateOrderItem = (id,data) => axios.put(`${API}/${id}`, data)
export const deleteOrderItem = (id) => axios.delete(`${API}/${id}`)