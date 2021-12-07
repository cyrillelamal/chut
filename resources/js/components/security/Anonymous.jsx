import React from "react";
import {Navigate} from "react-router-dom";
import {UserContext} from "./UserContext";

export default class Anonymous extends React.Component {
    render() {
        return null === this.context.user
            ? (<div>{this.props.children}</div>)
            : (<Navigate to="/conversations"/>);
    }
}

Anonymous.contextType = UserContext;
