import rss from "@astrojs/rss";
import { getCollection } from "astro:content";

export async function GET(context) {
  const thoughts = await getCollection("thinks");

  return rss({
    title: "Pat thinks",
    description:
      "A collection of Pat's thoughts that can vary but might be seen as unhinged.",
    site: context.site,
    items: thoughts.map((post) => ({
      title: post.data.title,
      link: `/thinks/${post.slug}`,
      pubDate: post.data.pubDate,
      content: post.body,
    })),
    xmlns: {
      media: "http://search.yahoo.com/mrss/",
    },
    customData: `
      <language>en-gb</language>
      <image>
        <url>https://parpok.xyz/content/avatar.png</url>
        <title>Pat thinks</title>
        <link>https://parpok.xyz/</link>
      </image>
      <media:thumbnail url="https://parpok.xyz/content/avatar.png" width="144" height="144" />
    `,
  });
}
