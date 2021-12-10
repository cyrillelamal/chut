import React from "react";
import {Nav} from "react-bootstrap";
import CommunicationCenter from "./CommunicationCenter";
import {withTranslation} from "react-i18next";

class Navigation extends React.Component {
    handleSelect = (k, e) => {
        e.preventDefault();
        e.stopPropagation();

        this.props.setTab(k);
    }

    render() {
        const {t} = this.props;

        return (
            <Nav fill variant="tabs" activeKey={this.props.tab} onSelect={this.handleSelect}>
                <Nav.Item>
                    <Nav.Link eventKey={CommunicationCenter.TABS.PARTICIPATION_LIST}>
                        {t('navigation.recent_dialogues')}
                    </Nav.Link>
                </Nav.Item>
                <Nav.Item>
                    <Nav.Link eventKey={CommunicationCenter.TABS.PRIVATE_MESSAGE}>
                        {t('navigation.private_message')}
                    </Nav.Link>
                </Nav.Item>
                <Nav.Item>
                    <Nav.Link eventKey={CommunicationCenter.TABS.PUBLIC_CONVERSATION}>
                        {t('navigation.start_conversation')}
                    </Nav.Link>
                </Nav.Item>
            </Nav>
        );
    }
}

export default withTranslation()(Navigation);
