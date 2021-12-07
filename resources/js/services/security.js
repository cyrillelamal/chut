import axios from "axios";
import User from "../models/User";

export const getUser = () => localStorage.getItem('user');

export const getCsrfToken = async () => {
    await axios.get('/sanctum/csrf-cookie');

    return document.cookie
        .split('; ')
        .find(row => row.startsWith('XSRF-TOKEN='))
        .split('=')[1];
}

export const register = async (data) => axios.post('/api/register', data);

export const login = async (data) => {
    const {email} = data;
    return axios.post('/api/login', Object.assign(data, {'device_name': navigator.userAgent}))
        .then(() => {
            const user = new User(email);
            localStorage.setItem('user', JSON.stringify(user));
            return user;
        });
}

export const logout = async () => axios.post('/api/logout').then(() => {
    localStorage.removeItem('user');
    return null;
});
