import React from "react";
import {Nav} from "react-bootstrap";
import CommunicationCenter from "./CommunicationCenter";

export default class Navigation extends React.Component {
    handleSelect = (k, e) => {
        e.preventDefault();
        e.stopPropagation();

        this.props.setTab(k);
    }

    render() {
        return (
            <Nav fill variant="tabs" activeKey={this.props.tab} onSelect={this.handleSelect}>
                <Nav.Item>
                    <Nav.Link eventKey={CommunicationCenter.TABS.PARTICIPATION_LIST}>
                        {'Recent dialogues'}{/* TODO: i18n */}
                    </Nav.Link>
                </Nav.Item>
                <Nav.Item>
                    <Nav.Link eventKey={CommunicationCenter.TABS.PRIVATE_MESSAGE}>
                        {'Send private message'}{/* TODO: i18n */}
                    </Nav.Link>
                </Nav.Item>
                <Nav.Item>
                    <Nav.Link eventKey={CommunicationCenter.TABS.PUBLIC_CONVERSATION}>
                        {'Start conversation'}{/* TODO: i18n */}
                    </Nav.Link>
                </Nav.Item>
            </Nav>
        );
    }
}
