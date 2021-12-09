import React from "react";
import {Card} from "react-bootstrap";

export default class ParticipationPreview extends React.Component {
    render() {
        return (
            <Card className="my-2">
                <Card.Header>{this.title}</Card.Header>
                <Card.Body>
                    <Card.Text>{this.body}</Card.Text>
                    <a href={`/conversations/${this.conversationId}`} className="stretched-link"/>
                </Card.Body>
                <Card.Footer>{this.createdAt}</Card.Footer>
            </Card>
        );
    }

    get title() {
        return this.props.hasOwnProperty('visible_title') ? this.props.visible_title : '';
    }

    get body() {
        const message = this.props.hasOwnProperty('last_available_message')
            ? this.props.last_available_message
            : '';

        const body = null === message ? '' : message.body;

        return body.length < 127 ? body : `${body.slice(0, 127)}...`;
    }

    get createdAt() {
        return this.props.hasOwnProperty('updated_at')
            ? this.props.updated_at
            : '';
    }

    get conversationId() {
        return this.props.hasOwnProperty('conversation_id') ? this.props.conversation_id : null;
    }
}
