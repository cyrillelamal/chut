import React from "react";
import {CloseButton, Toast} from "react-bootstrap";
import {Link} from "react-router-dom";

export default class Notification extends React.Component {
    STYLE = {
        transform: 'rotate(0)',
    }

    close = (e) => {
        e.preventDefault();
        e.stopPropagation();
        this.props.remove(this.uid)
    }

    render() {
        return (
            <Toast>
                <Toast.Header closeButton={false}>
                    <strong className="me-auto">{this.name}</strong>
                    <small className="text-muted">{this.createdAt}</small>
                    <CloseButton onClick={this.close}/>
                </Toast.Header>
                <Toast.Body style={this.STYLE}>
                    {this.body}
                    <Link to={this.href} className="stretched-link"/>
                </Toast.Body>
            </Toast>
        );
    }

    get uid() {
        return this.props.hasOwnProperty('uid') ? this.props.uid : this.href;
    }

    get name() {
        return this.props.name;
    }

    get createdAt() {
        return this.props.hasOwnProperty('createdAt') ? this.props.createdAt : '';
    }

    get body() {
        return this.props.hasOwnProperty('body') ? this.props.body : '';
    }

    get conversationId() {
        return this.props.hasOwnProperty('conversationId') ? this.props.conversationId : '';
    }

    get href() {
        return `/conversations/${this.conversationId}`
    }
}
