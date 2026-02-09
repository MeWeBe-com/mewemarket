let protooPort = 4443;

if (window.location.hostname === 'test.mediasoup.org')
	protooPort = 4444;

export function getProtooUrl({ roomId, peerId })
{
	const hostname = window.location.hostname;

	return `wss://mewemarket.com/apps/mediasoup-demo-3:${protooPort}/?roomId=${roomId}&peerId=${peerId}`;
}
