import React from "react";
import {Navigate} from "react-router-dom";
import {UserContext} from "./UserContext";

export default class Authenticated extends React.Component {
    render() {
        return null === this.context.user
            ? (<Navigate to="/login"/>)
            : (<div>{this.props.children}</div>);
    }
}

Authenticated.contextType = UserContext;
