// src/api/productApi.js
import axios from "axios";

const API_URL = "http://127.0.0.1:8000/api/reviews";

export const getReviews = (search = "", page = 1) => {
  return axios.get(`${API_URL}?search=${search}&page=${page}`);
};

export const getReview = (id) => {
  return axios.get(`${API_URL}/${id}`);
};

export const createReview = (data) => {
  return axios.post(API_URL, data);
};

export const updateReview = (id, data) => {
  return axios.put(`${API_URL}/${id}`, data);
};

export const deleteReview = (id) => {
  return axios.delete(`${API_URL}/${id}`);
};
