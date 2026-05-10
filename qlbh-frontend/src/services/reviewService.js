import axios from "axios"

const API = "http://127.0.0.1:8000/api/reviews"

export const getReviews = () => axios.get(API)
export const getReview = (id) => axios.get(`${API}/${id}`)
export const createReview = (data) => axios.post(API, data)
export const updateReview = (id, data) => axios.put(`${API}/${id}`, data)
export const deleteReview = (id) => axios.delete(`${API}/${id}`)