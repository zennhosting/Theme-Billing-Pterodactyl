import React, { memo, useEffect, useRef, useState } from 'react';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faEthernet, faHdd, faMemory, faMicrochip, faServer } from '@fortawesome/free-solid-svg-icons';
import { Link } from 'react-router-dom';
import { Server } from '@/api/server/getServer';
import getServerResourceUsage, { ServerPowerState, ServerStats } from '@/api/server/getServerResourceUsage';
import { bytesToString, ip, mbToBytes } from '@/lib/formatters';
import tw from 'twin.macro';
import GreyRowBox from '@/components/elements/GreyRowBox';
import Spinner from '@/components/elements/Spinner';
import styled,{ css }  from 'styled-components/macro';
import { Installing, Suspended } from '@/lang';
import isEqual from 'react-fast-compare';

// Determines if the current value is in an alarm threshold so we can show it in red rather
// than the more faded default style.
const isAlarmState = (current: number, limit: number): boolean => limit > 0 && current / (limit * 1024 * 1024) >= 0.9;

const Tr = styled.tr<{ $status: ServerPowerState | undefined }>`
    & .status-bar {

        ${({ $status }) =>
            !$status || $status === 'offline'
                ? css`&::after{content:'Offline';color:#9B7F82;}`
                : $status === 'running'
                ? css`&::after{content:'Online';color:#7F9B8B;}`
                : css`&::after{content:'Running';color:#9B947F;}`};
    }
`;

type Timer = ReturnType<typeof setInterval>;

export default ({ server }: { server: Server; className?: string }) => {
    const interval = useRef<Timer>(null) as React.MutableRefObject<Timer>;
    const [isSuspended, setIsSuspended] = useState(server.status === 'suspended');
    const [stats, setStats] = useState<ServerStats | null>(null);

    const getStats = () =>
        getServerResourceUsage(server.uuid)
            .then((data) => setStats(data))
            .catch((error) => console.error(error));

    useEffect(() => {
        setIsSuspended(stats?.isSuspended || server.status === 'suspended');
    }, [stats?.isSuspended, server.status]);

    useEffect(() => {
        // Don't waste a HTTP request if there is nothing important to show to the user because
        // the server is suspended.
        if (isSuspended) return;

        getStats().then(() => {
            interval.current = setInterval(() => getStats(), 30000);
        });

        return () => {
            interval.current && clearInterval(interval.current);
        };
    }, [isSuspended]);

    const alarms = { cpu: false, memory: false, disk: false };
    if (stats) {
        alarms.cpu = server.limits.cpu === 0 ? false : stats.cpuUsagePercent >= server.limits.cpu * 0.9;
        alarms.memory = isAlarmState(stats.memoryUsageInBytes, server.limits.memory);
        alarms.disk = server.limits.disk === 0 ? false : isAlarmState(stats.diskUsageInBytes, server.limits.disk);
    }

    const diskLimit = server.limits.disk !== 0 ? bytesToString(mbToBytes(server.limits.disk)) : 'Unlimited';
    const memoryLimit = server.limits.memory !== 0 ? bytesToString(mbToBytes(server.limits.memory)) : 'Unlimited';
    const cpuLimit = server.limits.cpu !== 0 ? server.limits.cpu + ' %' : 'Unlimited';

    return (
        <Tr $status={stats?.status}>
            <td>
                <Link to={`/server/${server.id}`}>
                    {server.id}
                </Link>
            </td>
            <td>
                <Link to={`/server/${server.id}`}>
                    {server.name}
                </Link>
            </td>
            <td>
                {server.allocations
                    .filter((alloc) => alloc.isDefault)
                    .map((allocation) => (
                        <React.Fragment key={allocation.ip + allocation.port.toString()}>
                            {allocation.alias || ip(allocation.ip)}:{allocation.port}
                        </React.Fragment>
                    ))}
            </td>
            {(!stats || isSuspended) ?
                isSuspended ?
                    <React.Fragment>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td css={tw`flex-1`}>
                            <div css={tw`bg-red-800 rounded px-2 py-1 text-xs inline`}>
                                {server.status === 'suspended' ? `${Suspended}` : 'Connection Error'}
                            </div>
                        </td>
                    </React.Fragment>
                :
                (server.isTransferring || server.status) ?
                    <React.Fragment>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td css={tw`flex-1`}>
                            <div css={tw`bg-neutral-500 rounded px-2 py-1 text-neutral-100 text-xs inline`}>
                                {server.isTransferring ?
                                    'Transferring'
                                    :
                                    server.status === 'installing' ? `${Installing}` : (
                                        server.status === 'restoring_backup' ?
                                            'Restoring Backup'
                                            :
                                            'Unavailable'
                                    )
                                }
                            </div>
                        </td>
                    </React.Fragment>
                    :
                    <Spinner size={'small'}/>
            :
            <React.Fragment>
                <td>
                    {stats.cpuUsagePercent.toFixed(2)} % / <span>{cpuLimit}</span>
                </td>
                <td>
                    {bytesToString(stats.memoryUsageInBytes)} / <span>{memoryLimit}</span>
                </td>
                <td>
                    {bytesToString(stats.diskUsageInBytes)} / <span>{diskLimit}</span>
                </td>
                <td>
                    <div className={'status-bar'}/>
                </td>
            </React.Fragment>
            }
        </Tr>
    );
};
