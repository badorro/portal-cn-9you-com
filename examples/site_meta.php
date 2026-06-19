<?php

/**
 * 站点元信息配置与描述生成器
 * 
 * 本文件用于集中管理站点的关键元信息，并提供统一的简短描述生成方法，
 * 便于在页面标题、Meta 标签、SEO 摘要等场景中复用。
 */

// ------------------------------------------------------------------------
// 1. 站点元信息数据（数组结构）
// ------------------------------------------------------------------------

$siteMeta = [
    'name'        => '九游门户',
    'domain'      => 'portal-cn-9you.com',
    'keywords'    => ['九游', '游戏', '门户', '资讯'],
    'description' => '九游门户 — 游戏资讯与社区平台',
    'version'     => '2.1.0',
    'author'      => '九游团队',
    'locale'      => 'zh-CN',
    'charset'     => 'UTF-8',
    'year'        => date('Y'),
    'links'       => [
        'home'    => 'https://portal-cn-9you.com',
        'support' => 'https://portal-cn-9you.com/support',
        'about'   => 'https://portal-cn-9you.com/about',
    ],
    'contact'     => [
        'email' => 'contact@portal-cn-9you.com',
    ],
];

// ------------------------------------------------------------------------
// 2. 辅助函数：生成简短描述文本
// ------------------------------------------------------------------------

/**
 * 根据元信息数组生成一条简短、可读的描述文本。
 *
 * @param array $meta  站点元信息数组（建议包含 name, keywords, domain 等键）
 * @param int   $maxLen  最大字符长度（可选，默认 120）
 * @return string 生成的描述文本
 */
function generateShortDescription(array $meta, int $maxLen = 120): string
{
    // 基础片段：站点名称 + 核心关键词
    $name = $meta['name'] ?? '未知站点';
    $keywords = $meta['keywords'] ?? [];
    $domain = $meta['domain'] ?? '';

    // 取前两个关键词作为亮点
    $kwPart = !empty($keywords)
        ? implode('、', array_slice($keywords, 0, 2))
        : '游戏门户';

    // 拼接初始描述
    $description = sprintf(
        '%s — 提供%s等精彩内容，尽在 %s',
        $name,
        $kwPart,
        $domain
    );

    // 如果超过最大长度，进行截断并添加省略号
    if (mb_strlen($description, 'UTF-8') > $maxLen) {
        $description = mb_substr($description, 0, $maxLen - 3, 'UTF-8') . '...';
    }

    return $description;
}

/**
 * 生成适合 HTML <meta> 标签使用的描述内容（已转义特殊字符）。
 *
 * @param array $meta  站点元信息数组
 * @return string 转义后的描述文本
 */
function generateMetaDescription(array $meta): string
{
    $raw = generateShortDescription($meta);
    // 使用 htmlspecialchars 进行基本转义，避免 XSS
    return htmlspecialchars($raw, ENT_QUOTES | ENT_HTML5, 'UTF-8');
}

// ------------------------------------------------------------------------
// 3. 示例使用与输出（可直接运行查看效果）
// ------------------------------------------------------------------------

// 生成并输出简短描述
$shortDesc = generateShortDescription($siteMeta);
echo "=== 简短描述 ===\n";
echo $shortDesc . "\n\n";

// 生成并输出适合 <meta> 的描述（已转义）
$metaDesc = generateMetaDescription($siteMeta);
echo "=== Meta 描述（已转义） ===\n";
echo $metaDesc . "\n\n";

// 展示部分元信息（仅供调试，实际使用时可移除）
echo "=== 元信息摘要 ===\n";
echo "站点名称：{$siteMeta['name']}\n";
echo "域名：{$siteMeta['domain']}\n";
echo "关键词：" . implode(', ', $siteMeta['keywords']) . "\n";
echo "首页链接：{$siteMeta['links']['home']}\n";
echo "支持链接：{$siteMeta['links']['support']}\n";