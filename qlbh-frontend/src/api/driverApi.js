// src/api/driverApi.js
import axiosInstance from "./axiosInstance";

const API_URL = "/drivers";

export const getDrivers = (search = "", page = 1) => {
  return axiosInstance.get(`${API_URL}?search=${search}&page=${page}`);
};

export const getDriver = (id) => {
  return axiosInstance.get(`${API_URL}/${id}`);
};

export const createDriver = (data) => {
  return axiosInstance.post(API_URL, data);
};

export const updateDriver = (id, data) => {
  return axiosInstance.put(`${API_URL}/${id}`, data);
};

export const deleteDriver = (id) => {
  return axiosInstance.delete(`${API_URL}/${id}`);
};
