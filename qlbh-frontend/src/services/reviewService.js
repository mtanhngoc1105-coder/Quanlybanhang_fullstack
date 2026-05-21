import axiosInstance from "../api/axiosInstance"

const API = "/api/reviews"

export const getReviews = () => axiosInstance.get(API)
export const getReview = (id) => axiosInstance.get(`${API}/${id}`)
export const createReview = (data) => axiosInstance.post(API, data)
export const updateReview = (id, data) => axiosInstance.put(`${API}/${id}`, data)
export const deleteReview = (id) => axiosInstance.delete(`${API}/${id}`)