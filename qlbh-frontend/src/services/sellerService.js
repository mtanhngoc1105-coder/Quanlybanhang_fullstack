import axiosInstance from "../api/axiosInstance"

const API = "/api/sellers"

export const getSellers = () => axiosInstance.get(API)
export const getSeller = (id) => axiosInstance.get(`${API}/${id}`)
export const createSeller = (data) => axiosInstance.post(API, data)
export const updateSeller = (id, data) => axiosInstance.put(`${API}/${id}`, data)
export const deleteSeller = (id) => axiosInstance.delete(`${API}/${id}`)