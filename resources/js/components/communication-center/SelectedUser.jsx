import React from "react";
import {Card} from "react-bootstrap";

export default class SelectedUser extends React.Component {
    handleClick = (e) => {
        e.preventDefault();
        e.stopPropagation();

        this.props.removeUser && this.props.removeUser(this.id);
    }

    render() {
        return (
            <Card className="my-2">
                <Card.Body>
                    <Card.Title>
                        {this.name}
                    </Card.Title>
                    <Card.Subtitle>
                        {this.email}
                    </Card.Subtitle>
                    <a href="#" className="stretched-link" onClick={this.handleClick}/>
                </Card.Body>
            </Card>
        );
    }

    get id() {
        return this.props.hasOwnProperty('id') ? this.props.id : this.email;
    }

    get name() {
        return this.props.hasOwnProperty('name') ? this.props.name : '';
    }

    get email() {
        return this.props.hasOwnProperty('email') ? this.props.email : '';
    }
}
