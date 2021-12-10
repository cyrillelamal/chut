require('./bootstrap');

import React from "react";
import ReactDom from "react-dom";
import {BrowserRouter} from "react-router-dom";

import "./i18n";

import App from "./components/App";

ReactDom.render(
    <BrowserRouter>
        <App/>
    </BrowserRouter>,
    document.getElementById('root')
);
