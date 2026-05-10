import axios from "axios"

const API = "http://127.0.0.1:8000/api/drivers"

export const getDrivers = () => axios.get(API)
export const getDriver = (id) => axios.get(`${API}/${id}`)
export const createDriver = (data) => axios.post(API, data)
export const updateDriver = (id, data) => axios.put(`${API}/${id}`, data)
export const deleteDriver = (id) => axios.delete(`${API}/${id}`)