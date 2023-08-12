import React, { useEffect, useState, useMemo } from 'react';
import {
    faClock,
    faCloudDownloadAlt,
    faCloudUploadAlt,
    faHdd,
    faMemory,
    faMicrochip,
    faWifi,
} from '@fortawesome/free-solid-svg-icons';
import { bytesToString, ip, mbToBytes } from '@/lib/formatters';
import { ServerContext } from '@/state/server';
import { SocketEvent, SocketRequest } from '@/components/server/events';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import UptimeDuration from '@/components/server/UptimeDuration';
import StatBlock from '@/components/server/console/StatBlock';
import useWebsocketEvent from '@/plugins/useWebsocketEvent';
import classNames from 'classnames';
import styled from 'styled-components/macro';

const DetailsItem = styled.div`
    position:relative;
    width:calc(33% - 10px);
    background-color:var(--secondary);
    border-radius:15px;
    height:150px;
    overflow:hidden;
    z-index:10;
    margin-right:10px;
    margin-left:10px;
    margin-bottom:20px;
    align-items:center;
    display:flex;

    &:first-of-type{
        margin-left:0;
    }
    &:last-of-type{
        margin-right:0;
    }
    .icon{
        font-size:17em;
        color:black;
        opacity:.3;
        transform: rotate(-36deg) translate(-45px, -68px);
        position:absolute;
        z-index:-1;
    }
    .content{
        max-width:200px;
        width:100%;
        margin-left:auto;
    }
    .content p{
        font-size:calc(2em + 50%);
        font-weight:bold;
    }
    @media only screen and (max-width: 979px){
        &{
            width:100%;
            margin-left:0;
            margin-right:0;
        }
    }
`;

type Stats = Record<'memory' | 'cpu' | 'disk' | 'uptime' | 'rx' | 'tx', number>;

const ServerDetailsBlock = ({ className }: { className?: string }) => {
    const [stats, setStats] = useState<Stats>({ memory: 0, cpu: 0, disk: 0, uptime: 0, tx: 0, rx: 0 });

    const status = ServerContext.useStoreState((state) => state.status.value);
    const connected = ServerContext.useStoreState((state) => state.socket.connected);
    const instance = ServerContext.useStoreState((state) => state.socket.instance);
    const limits = ServerContext.useStoreState((state) => state.server.data!.limits);
    const allocation = ServerContext.useStoreState((state) => {
        const match = state.server.data!.allocations.find((allocation) => allocation.isDefault);

        return !match ? 'n/a' : `${match.alias || ip(match.ip)}:${match.port}`;
    });

    
    const Limits = useMemo(
        () => ({
            cpu: limits?.cpu ? `${limits.cpu}%` : null,
            memory: limits?.memory ? bytesToString(mbToBytes(limits.memory)) : null,
            disk: limits?.disk ? bytesToString(mbToBytes(limits.disk)) : null,
        }),
        [limits]
    );

    useEffect(() => {
        if (!connected || !instance) {
            return;
        }

        instance.send(SocketRequest.SEND_STATS);
    }, [instance, connected]);

    useWebsocketEvent(SocketEvent.STATS, (data) => {
        let stats: any = {};
        try {
            stats = JSON.parse(data);
        } catch (e) {
            return;
        }

        setStats({
            memory: stats.memory_bytes,
            cpu: stats.cpu_absolute,
            disk: stats.disk_bytes,
            tx: stats.network.tx_bytes,
            rx: stats.network.rx_bytes,
            uptime: stats.uptime || 0,
        });
    });
    ;

    return (
        <div className={'break-words flex flex-wrap'}>
            <DetailsItem className={'text-xs mt-2'}>
                <div className='icon'>
                    <FontAwesomeIcon icon={faMicrochip} fixedWidth className={'mr-1'}/>
                </div>
                <div className="content">
                    <p>{stats.cpu.toFixed(2)}%</p>
                    <span className={'text-neutral-500'}> / {Limits.cpu || <>&infin;</>}</span>
                </div>
            </DetailsItem>
            <DetailsItem className={'text-xs mt-2'}>
                <div className='icon'>
                    <FontAwesomeIcon icon={faMemory} fixedWidth className={'mr-1'}/> 
                </div>
                <div className="content">
                    <p>{bytesToString(stats.memory)}</p>
                    <span className={'text-neutral-500'}> / {Limits.memory || <>&infin;</>}</span>
                </div>
            </DetailsItem>
            <DetailsItem className={'text-xs mt-2'}>
                <div className='icon'>
                    <FontAwesomeIcon icon={faHdd} fixedWidth className={'mr-1'}/>
                </div>
                <div className="content">
                    <p>{bytesToString(stats.disk)}</p>
                    <span className={'text-neutral-500'}> / {Limits.disk || <>&infin;</>}</span>
                </div>
            </DetailsItem>
        </div>
    );
};

export default ServerDetailsBlock;
