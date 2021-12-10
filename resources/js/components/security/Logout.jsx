import React from "react";
import {logout} from "../../services/security";
import {UserContext} from "./UserContext";
import Loading from "../Loading";

export default class Logout extends React.Component {
    async componentDidMount() {
        logout()
            .then((user) => this.context.setUser(user))
            .then(() => location.replace('/'));
        // This hard redirect ensures that the CSRF token and the application context are reloaded.
    }

    render() {
        return (<Loading/>);
    }
}

Logout.contextType = UserContext;
