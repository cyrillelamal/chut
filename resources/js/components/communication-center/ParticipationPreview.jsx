import React from "react";
import {Card} from "react-bootstrap";
import {Link} from "react-router-dom";

export default class ParticipationPreview extends React.Component {
    render() {
        return (
            <Card className="my-2">
                <Card.Header>{this.title}</Card.Header>
                <Card.Body>
                    <Card.Text>{this.body}</Card.Text>
                    <Link to={this.href} className="stretched-link"/>
                </Card.Body>
                <Card.Footer>{this.updatedAt}</Card.Footer>
            </Card>
        );
    }

    get title() {
        return this.participation.title;
    }

    get body() {
        const body = this.participation.body;
        return body.length < 127 ? body : `${body.slice(0, 127)}...`;
    }

    get updatedAt() {
        return this.participation.updatedAt;
    }

    get href() {
        return this.participation.href;
    }

    /**
     * @return {Participation}
     */
    get participation() {
        return this.props.participation;
    }
}
