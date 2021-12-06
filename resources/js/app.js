require('./bootstrap');

import React from "react";
import ReactDom from "react-dom";
import {BrowserRouter} from "react-router-dom";

import {App} from "./components/App";


// const {log} = console;

// axios.get('/sanctum/csrf-cookie').then(() => {
//         axios.post('/api/login', {
//             email: 'elwin.nolan@example.com',
//             password: 'password',
//             device_name: 'bar',
//         }).then(log);
//     }
// );

// axios.post('/api/conversations', {
//     users: [1],
// }).then(log);

// axios.post('/api/conversations/480/messages', {
//     body: 'Salut !',
// }).then(log)

// Echo.private('users.1')
//     .listen('MessageSent', log)
//     .listen('ConversationStarted', log);

ReactDom.render(
    <BrowserRouter>
        <App/>
    </BrowserRouter>,
    document.getElementById('root')
);
