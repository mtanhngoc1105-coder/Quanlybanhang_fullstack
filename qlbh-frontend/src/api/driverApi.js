// src/api/driverApi.js
import axios from "axios";

const API_URL = "http://127.0.0.1:8000/api/drivers";

export const getDrivers = (search = "", page = 1) => {
  return axios.get(`${API_URL}?search=${search}&page=${page}`);
};

export const getDriver = (id) => {
  return axios.get(`${API_URL}/${id}`);
};

export const createDriver = (data) => {
  return axios.post(API_URL, data);
};

export const updateDriver = (id, data) => {
  return axios.put(`${API_URL}/${id}`, data);
};

export const deleteDriver = (id) => {
  return axios.delete(`${API_URL}/${id}`);
};
