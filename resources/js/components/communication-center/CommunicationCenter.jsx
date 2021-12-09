import React from "react";
import Authenticated from "../security/Authenticated";
import Navigation from "./Navigation";
import ParticipationList from "./ParticipationList";
import PrivateMessage from "./PrivateMessage";
import PublicConversation from "./PublicConversation";

export default class CommunicationCenter extends React.Component {
    static TABS = {
        PARTICIPATION_LIST: 'PARTICIPATION_LIST',
        PRIVATE_MESSAGE: 'PRIVATE_MESSAGE',
        PUBLIC_CONVERSATION: 'PUBLIC_CONVERSATION',
    }

    static _TABS = {
        PARTICIPATION_LIST: ParticipationList,
        PRIVATE_MESSAGE: PrivateMessage,
        PUBLIC_CONVERSATION: PublicConversation,
    }

    constructor(props) {
        super(props);
        this.state = {
            tab: CommunicationCenter.TABS.PARTICIPATION_LIST,
        };
    }

    render() {
        const Tab = CommunicationCenter._TABS[this.state.tab];

        return (
            <Authenticated>
                <div className="container p-2 p-sm-5 vh-100">
                    <div className="h-100 d-flex flex-column">
                        <Navigation tab={this.state.tab} setTab={this.setTab}/>
                        <div className="flex-grow-1">
                            {<Tab/>}
                        </div>
                    </div>
                </div>
            </Authenticated>
        );
    }

    setTab = (tab) => {
        this.setState({tab});
    }
}
