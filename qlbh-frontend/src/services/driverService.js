import axiosInstance from "../api/axiosInstance"

const API = "/drivers"

export const getDrivers = () => axiosInstance.get(API)
export const getDriver = (id) => axiosInstance.get(`${API}/${id}`)
export const createDriver = (data) => axiosInstance.post(API, data)
export const updateDriver = (id, data) => axiosInstance.put(`${API}/${id}`, data)
export const deleteDriver = (id) => axiosInstance.delete(`${API}/${id}`)