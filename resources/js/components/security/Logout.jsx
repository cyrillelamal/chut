import React from "react";
import {Navigate} from "react-router-dom";
import {logout} from "../../services/security";
import {UserContext} from "./UserContext";

export default class Logout extends React.Component {
    async componentDidMount() {
        await logout().then((user) => this.context.setUser(user));
    }

    render() {
        return (
            <Navigate to="/"/>
        );
    }
}

Logout.contextType = UserContext;
