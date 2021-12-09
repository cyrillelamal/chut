import React from "react";
import {Card} from "react-bootstrap";

export default class Message extends React.Component {
    render() {
        return (
            <Card className="my-2">
                <Card.Header>{this.authorName}</Card.Header>
                <Card.Body>
                    <Card.Text>{this.body}</Card.Text>
                </Card.Body>
                <Card.Footer>{this.createdAt}</Card.Footer>
            </Card>
        );
    }

    get body() {
        return this.props.hasOwnProperty('body') ? this.props.body : '';
    }

    get author() {
        return this.props.hasOwnProperty('author') ? this.props.author : {};
    }

    get authorName() {
        return this.author.name ?? '';
    }

    get createdAt() {
        return this.props.hasOwnProperty('created_at')
            ? this.props.created_at
            : '';
    }
}
