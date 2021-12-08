import React from "react";

export default class UserPreview extends React.Component {
    render() {
        return (
            <div>
                <p>{this.name}</p>
                <p className="text-muted">{this.email}</p>
            </div>
        );
    }

    get name() {
        return this.props.hasOwnProperty('name') ? this.props.name : '';
    }

    get email() {
        return this.props.hasOwnProperty('email') ? this.props.email : '';
    }
}
