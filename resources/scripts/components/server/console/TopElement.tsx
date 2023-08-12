import React from 'react';
import { ServerContext } from '@/state/server';
import styled from 'styled-components/macro';
import CopyOnClick from '@/components/elements/CopyOnClick';
import { ip } from '@/lib/formatters';
import * as Icon from 'react-feather';

const DetailsItem = styled.div`
    position:relative;
    background-color:var(--secondary);
    border-radius:15px;
    overflow:hidden;
    margin-bottom:10px;
    padding:20px 25px;
`;

const TopElement = () => {
    const name = ServerContext.useStoreState(state => state.server.data!.name);
    const id = ServerContext.useStoreState(state => state.server.data!.id);
    const node = ServerContext.useStoreState((state) => state.server.data!.node);
    const status = ServerContext.useStoreState((state) => state.status.value);
    const allocation = ServerContext.useStoreState((state) => {
        const match = state.server.data!.allocations.find((allocation) => allocation.isDefault);

        return !match ? 'n/a' : `${match.alias || ip(match.ip)}:${match.port}`;
    });

    return (
        <DetailsItem>
            <h1 className='text-2xl font-semibold'>{name}</h1>
            <div className="md:flex items-center gap-x-6">
                <div className={'flex align-center gap-x-1'}>
                    {status == 'offline' ?
                        <>
                            <span css="color:#AC2427;"><Icon.Radio size={24}/></span>
                            Offline
                        </>
                        :
                        <>
                            {status == 'running' ?
                                <>
                                <span css="color:#14914E;"><Icon.Radio size={24}/></span>
                                Online
                                </>
                            :
                            <>
                                {status == 'stopping' ?
                                    <>
                                        <span css="color:#AC2427;"><Icon.Radio size={24}/></span>
                                        Offline
                                    </>
                                :
                                <>
                                    <span css="color:orange;"><Icon.Radio size={24}/></span>
                                    Starting
                                </>
                                }
                            </>
                            }
                        </>
                    }
                </div>
                <div className={'flex align-center gap-x-1'}>
                    <CopyOnClick text={allocation}>
                        <>
                            <span css={'color:var(--primary);'}><Icon.Globe size={24}/></span>
                            {allocation}
                        </>
                    </CopyOnClick>
                </div>
                <div className={'flex align-center gap-x-1'}>
                    <CopyOnClick text={id}>
                        <>
                            <span css={'color:var(--primary);'}><Icon.Hash size={24}/></span>
                            {id}
                        </>
                    </CopyOnClick>
                </div>
                <div className={'flex align-center gap-x-1'}>
                    <span css={'color:var(--primary);'}><Icon.Server size={24}/></span>
                    {node}
                </div>
            </div>
        </DetailsItem>
    );
};

export default TopElement;
