// src/api/driverOrderApi.js
import axios from "axios";

const API_URL = "http://127.0.0.1:8000/api/driver-orders";

export const getDriverOrders = (search = "", page = 1) => {
  return axios.get(`${API_URL}?search=${search}&page=${page}`);
};

export const getDriverOrder = (id) => {
  return axios.get(`${API_URL}/${id}`);
};

export const createDriverOrder = (data) => {
  return axios.post(API_URL, data);
};

export const updateDriverOrder = (id, data) => {
  return axios.put(`${API_URL}/${id}`, data);
};

export const deleteDriverOrder = (id) => {
  return axios.delete(`${API_URL}/${id}`);
};
