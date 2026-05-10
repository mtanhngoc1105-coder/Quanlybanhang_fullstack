import axios from "axios"

const API = "http://127.0.0.1:8000/api/sellers"

export const getSellers = () => axios.get(API)
export const getSeller = (id) => axios.get(`${API}/${id}`)
export const createSeller = (data) => axios.post(API, data)
export const updateSeller = (id, data) => axios.put(`${API}/${id}`, data)
export const deleteSeller = (id) => axios.delete(`${API}/${id}`)